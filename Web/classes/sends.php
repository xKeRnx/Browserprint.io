<?php
class sends
{
	public $dbh;

	function __construct()
	{
		$db = new db();
		$this->dbh = $db->connect();
	}

	function getRemoteIP()
	{
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}
		return $_SERVER['REMOTE_ADDR'];
	}

	function generateRandomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?&$*+.;:,';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	function activateuser($hash)
	{
		$sql = "SELECT username, email, dDate from user_activate WHERE hash=(:hash)";
		$query = $this->dbh->prepare($sql);
		$query->bindParam(':hash', $hash, PDO::PARAM_STR);
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			$username = $res[0]->username;
			$email = $res[0]->email;
			$dDate = $res[0]->dDate;

			date_default_timezone_set("Europe/Berlin");
			$date = new DateTime($dDate);
			$mysqldate = $date->format('Y-m-d H:i:s');
			$yetmin30 = date('Y-m-d H:i:s', strtotime('-30 minute'));

			$sql = "SELECT name, status from users WHERE name=(:name)";
			$query = $this->dbh->prepare($sql);
			$query->bindParam(':name', $username, PDO::PARAM_STR);
			$query->execute();
			$res = $query->fetchAll(PDO::FETCH_OBJ);
			if ($query->rowCount() > 0) {
				$acc_status = $res[0]->status;
				if ($acc_status == 0) {
					if ($mysqldate >= $yetmin30) {
						$sql = "UPDATE users SET status=1 WHERE name=(:name)";
						$query = $this->dbh->prepare($sql);
						$query->bindParam(':name', $username, PDO::PARAM_STR);
						if ($query->execute()) {
							return 0;
						}
						return 3;
					} else {
						$this->sendactivate($username, $email);
						return 1;
					}
				} else {
					return 4;
				}
			} else {
				return 5;
			}
		}
		return 2;
	}

	function log($notitype, $reciver, $sender)
	{
		$sql = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
		$query =  $this->dbh->prepare($sql);
		$query->bindParam(':notiuser', $sender, PDO::PARAM_STR);
		$query->bindParam(':notireciver', $reciver, PDO::PARAM_STR);
		$query->bindParam(':notitype', $notitype, PDO::PARAM_STR);
		if ($query->execute()) {
			return true;
		}
		return false;
	}

	function bugreport($message, $category)
	{
		if (!filter_var($category, FILTER_VALIDATE_INT) === 0 || filter_var($category, FILTER_VALIDATE_INT) ===  false) {
			return false;
		}
		$category = filter_var($category, FILTER_SANITIZE_STRING);
		$message = filter_var($message, FILTER_SANITIZE_STRING);
		$username = 'Unknown';
		if (isset($_SESSION['ulogin'])) {
			$username = $_SESSION['ulogin'];
		}
		$sql = "insert into bugreport (username,category,message) values (:username,:category,:message)";
		$query = $this->dbh->prepare($sql);
		$query->bindParam(':username', $username, PDO::PARAM_STR);
		$query->bindParam(':category', $category, PDO::PARAM_STR);
		$query->bindParam(':message', $message, PDO::PARAM_STR);
		if ($query->execute()) {
			$this->log("has reported a Bug", "Admin", $username);
			return true;
		}
		return false;
	}

	function sendmail($email, $subject, $message)
	{
		require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/mailer/class.phpmailer.php';
		$mail = new PHPMailer(true);

		try {
			$mail->IsSMTP();
			$mail->isHTML(true);
			$mail->SMTPDebug  = 0;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = mail_secure;
			$mail->Host       = mail_host;
			$mail->Port       = mail_port;
			$mail->AddAddress($email);
			$mail->Username   = mail_username;
			$mail->Password   = mail_password;
			$mail->CharSet 	  = 'UTF-8';
			$mail->SetFrom(mail_sender, SERVENAME);
			$mail->Subject    = $subject;
			$mail->Body       = $message;
			$mail->AltBody    = $message;

			if ($mail->Send()) {
				return true;
			}
			return false;
		} catch (phpmailerException $ex) {
			return false;
		}
	}

	function sendactivate($name, $email)
	{
		$HASH = md5($name . 'activate' . base64_encode(random_bytes(32)));
		$sqlactiv = "insert into user_activate (username,email,hash) values (:username,:email,:hash)";
		$queryactiv = $this->dbh->prepare($sqlactiv);
		$queryactiv->bindParam(':username', $name, PDO::PARAM_STR);
		$queryactiv->bindParam(':email', $email, PDO::PARAM_STR);
		$queryactiv->bindParam(':hash', $HASH, PDO::PARAM_STR);
		$queryactiv->execute();

		$hashlink = Web_URL . 'activate/' . $HASH;
		$emailcont = 'Hello ' . $name . ', <br><br>
		Please click on following link to activate your account <a href="' . $hashlink . '">' . Web_URL . 'activate/...</a>
		<br> If you have not created an account then please contact our support.
		<br><br><br> With kind regards,
		<br>
		<br>'.SERVENAME.'
		<br>
		<br>	
		<br>The information contained in this email is intended solely for the addressee. If you are not the intended recipient, 
		<br>any form of disclosure, reproduction, distribution or any action taken or refrained from in reliance on it, is prohibited 
		<br>and may be unlawful. Please notify the sender immediately.
		';

		if ($this->sendmail($email, SERVENAME." - Account activation", $emailcont) == true) {
			return true;
		}
		return false;
	}

	function sendnewpw($name, $email)
	{
		$pw = $this->generateRandomString(16);
		$password = password_hash($pw, PASSWORD_DEFAULT);

		$sqlactiv = "UPDATE users SET password=(:password) WHERE name=(:username)";
		$queryactiv = $this->dbh->prepare($sqlactiv);
		$queryactiv->bindParam(':password', $password, PDO::PARAM_STR);
		$queryactiv->bindParam(':username', $name, PDO::PARAM_STR);

		if ($queryactiv->execute()) {
			$emailcont = 'Hello ' . $name . ', <br>
			<br>Your new password is: ' . $pw . '
			<br>If you have not tried to reset your password, please contact our support and change your email address if necessary.
			<br><br><br> With kind regards,
			<br>
			<br>'.SERVENAME.'
			<br>
			<br>	
			<br>The information contained in this email is intended solely for the addressee. If you are not the intended recipient, 
			<br>any form of disclosure, reproduction, distribution or any action taken or refrained from in reliance on it, is prohibited 
			<br>and may be unlawful. Please notify the sender immediately.
			';

			if ($this->sendmail($email, SERVENAME." - Password reset", $emailcont) == true) {
				return true;
			}
		}
		return false;
	}
}
