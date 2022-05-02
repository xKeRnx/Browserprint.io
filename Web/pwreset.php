<?php 
require_once('includes/config.php');

if (isset($_SESSION['ulogin'])) {
    header('location:'.$Web_URL);
}
$error = "0";
$sucs = "0";
if (isset($_POST['reset'])) {
    $email=$_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_STRING);
	
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.google_secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$sucs = "0";
				$error="$email is not a valid email address";
			}else{
				$sql = "SELECT name FROM users WHERE email=(:email)";
				$query = $dbh->prepare($sql);
				$query->bindParam(':email', $email, PDO::PARAM_STR);
				$query->execute();
				
				if ($query->rowCount() == 1) {
					$results=$query->fetchAll(PDO::FETCH_OBJ);
					$name = $results[0]->name;
					if($send->sendnewpw($name, $email) == true){
						$_POST = array();
						$sucs = "Password reset Successful! <br> We have sent you an email with the new Password.";
					}else{
						$sucs = "0";
						$error = "Email can not be sent, please contact our support";
					}
				}else{
					$sucs = "0";
					$error = "Email not exists!";
				}
			}
		}else{
            $sucs = "0";
            $error = "Robot verification failed, please try again.";
        }
    }else{
        $sucs = "0";
        $error = "Please do the robot verification.";
    }
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $_SERVERNAME; ?> - PW reset</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="<?php echo $Web_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $Web_URL; ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $Web_URL; ?>assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/forms/switches.css">
	
	<link href="<?php echo $Web_URL; ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Web_URL; ?>assets/css/custom.css" rel="stylesheet" type="text/css" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?php echo $Web_URL; ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $Web_URL; ?>assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/elements/alert.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
</head>
<body class="form">
    

    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

						<h1 class=""><a href="<?php echo $Web_URL; ?>"><span class="brand-name"><?php echo $_SERVERNAME; ?></span></a></h1>
                        <h3 class="">Password reset</h3>
						<p class="signup-link">New Here? <a href="register">Create an account</a></p>
                        <form class="text-left" method="post">
                            <div class="form">
							<?php if(@$error != "0"){ ?>
							<div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
								<?php echo $error; ?>
							</div> 

							<?php }elseif(@$sucs != "0" AND @$error == "0"){?>
							<div class="alert alert-arrow-right alert-icon-right alert-light-success mb-4" role="alert">
								 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
								 <?php echo $sucs; ?>
							</div>
							<?php } ?>
							
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
									<input id="email" name="email" type="email" class="form-control" placeholder="Email" value="<?php echo @$_POST['email']; ?>" required>
                                </div>
								<center><div class="g-recaptcha" data-sitekey="<?php echo google_public; ?>"></div></center><br><br>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button name="reset" type="submit" class="btn btn-primary" value="">Reset Password</button>
                                    </div>
                                    
                                </div>

                                <div class="field-wrapper">
                                    <!-- <a href="auth_pass_recovery.html" class="forgot-pass-link">Forgot Password?</a> -->
                                </div>

                            </div>
                        </form>                        
                        <?php echo $_FOOTTEXT; ?>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $Web_URL; ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $Web_URL; ?>bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $Web_URL; ?>bootstrap/js/bootstrap.min.js"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $Web_URL; ?>assets/js/authentication/form-1.js"></script>

</body>
</html>