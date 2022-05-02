<?php
$__TOKEN = "hardcodeshitbykernstudios";
include('includes/config.php');

$activesite = 'profile';

if (!isset($_SESSION['ulogin'])) {
	header('location:' . $Web_URL);
	exit();
} else {
	
	$sql = "SELECT password, id, name, dispname, email from users WHERE name=(:uname) AND status=1";
	$query = $dbh->prepare($sql);
	$query->bindParam(':uname', $_SESSION['ulogin'], PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() == 1) {
		$uid = $results[0]->id;
		$DispName = $results[0]->dispname;
		$username = $results[0]->name;
		$email = $results[0]->email;
		$hashed_password = $results[0]->password;

	} else {
		header("Location: " . $Web_URL);
		exit();
	}

	/* variable array for store errors */
	$errors = [];
	$suc = [];

	if (isset($_POST['save'])) {
		$errors = [];
		$suc = [];
		$displname = $_POST["displname"];
		$displname = filter_var($displname, FILTER_SANITIZE_STRING);

		$email  = $_POST["email"];
		$email = filter_var($email, FILTER_SANITIZE_STRING);
		$password  = $_POST["password"];
		$newpassword  = $_POST["newpassword"];
		$renewpassword  = $_POST["renewpassword"];

		if (password_verify($password, $hashed_password)) {
			if ($newpassword != "" and $renewpassword != "") {
				if ($newpassword === $renewpassword) {
					$hashednewpass = password_hash($newpassword, PASSWORD_DEFAULT);
					$sql = "UPDATE users SET password=(:password) WHERE name=(:name)";
					$query = $dbh->prepare($sql);
					$query->bindParam(':password', $hashednewpass, PDO::PARAM_STR);
					$query->bindParam(':name', $_SESSION['ulogin'], PDO::PARAM_STR);
					if ($query->execute()) {
						$notitype = 'Has changed his password';
						$reciver = 'Admin';
						$sender = $_SESSION['ulogin'];

						$sqlnoti = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
						$querynoti = $dbh->prepare($sqlnoti);
						$querynoti->bindParam(':notiuser', $sender, PDO::PARAM_STR);
						$querynoti->bindParam(':notireciver', $reciver, PDO::PARAM_STR);
						$querynoti->bindParam(':notitype', $notitype, PDO::PARAM_STR);
						$querynoti->execute();
						$suc[] = "Your password was successfully changed";
					} else {
						$errors[] = "SQL password change Error";
					}
				} else {
					$errors[] = "New passwords are not the same.";
				}
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors[] = "$email is not a valid email address";
			}
			if ($check->trashmail($email) == true) {
				$errors[] = "Throw away email addresses are not allowed";
			}

			if (empty($errors)) {
				$sql = "UPDATE users SET dispname=(:dispname), email=(:email) WHERE name=(:name)";
				$query = $dbh->prepare($sql);
				$query->bindParam(':dispname', $displname, PDO::PARAM_STR);
				$query->bindParam(':email', $email, PDO::PARAM_STR);
				$query->bindParam(':name', $_SESSION['ulogin'], PDO::PARAM_STR);
				if ($query->execute()) {
					$notitype = 'Has updated his profile settings';
					$reciver = 'Admin';
					$sender = $_SESSION['ulogin'];

					$sqlnoti = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
					$querynoti = $dbh->prepare($sqlnoti);
					$querynoti->bindParam(':notiuser', $sender, PDO::PARAM_STR);
					$querynoti->bindParam(':notireciver', $reciver, PDO::PARAM_STR);
					$querynoti->bindParam(':notitype', $notitype, PDO::PARAM_STR);
					$querynoti->execute();
					$suc[] = "Your settings have been successfully updated";
					$DispName = $displname;
					$bio = $aboutBio;
				} else {
					$errors[] = "SQL Update Error";
				}
			}
		} else {
			$errors[] = "Old Password is wrong!";
		}

	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('include/head.php'); ?>

	<!--  BEGIN CUSTOM STYLE FILE  -->
	<link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>plugins/dropify/dropify.min.css">
	<link href="<?php echo $Web_URL; ?>assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/forms/switches.css">
	<link href="<?php echo $Web_URL; ?>assets/css/tiny.css" rel="stylesheet" type="text/css">
	<script src="<?php echo $Web_URL; ?>assets/js/tiny.js"></script>
	<!--  END CUSTOM STYLE FILE  -->
</head>

<body class="sidebar-noneoverflow">
	<!-- BEGIN LOADER -->
	<div id="load_screen">
		<div class="loader">
			<div class="loader-content">
				<div class="spinner-grow align-self-center"></div>
			</div>
		</div>
	</div>
	<!--  END LOADER -->

	<!--  BEGIN NAVBAR  -->
	<?php include('include/navbar.php'); ?>
	<!--  END NAVBAR  -->

	<!--  BEGIN MAIN CONTAINER  -->
	<div class="main-container" id="container">

		<div class="overlay"></div>
		<div class="search-overlay"></div>

		<!--  BEGIN TOPBAR  -->
		<?php include('include/topbar.php'); ?>
		<!--  END TOPBAR  -->

		<!--  BEGIN CONTENT AREA  -->
		<div id="content" class="main-content">
			<div class="layout-px-spacing">

				<div class="account-settings-container layout-top-spacing">
					<form enctype="multipart/form-data" id="upset" method="post">

						<?php
						if (!empty($errors)) {
							/* display error */
							foreach ($errors as $keyError => $valueError) {
								echo '<div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">';
								echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>';
								echo $valueError;
								echo '</div>';
							}
						}

						if (!empty($suc)) {
							/* display Suc */
							foreach ($suc as $keySuc => $ValueSuc) {
								echo '<div class="alert alert-arrow-right alert-icon-right alert-light-success mb-4" role="alert">';
								echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>';
								echo $ValueSuc;
								echo '</div>';
							}
						}
						?>

						<div class="account-content">
							<div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
								<div class="row">
									
									<!-- General Information-->
									<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
										<div id="about" class="section about">
											<div class="info">
												<h5 class="">General Information</h5>
												<div class="row">
													<!-- Display Name -->
													<div class="col-sm-6">
														<div class="form-group">
															<label for="displname">Display Name</label>
															<input type="text" class="form-control mb-4" id="displname" name="displname" placeholder="Display Name" value="<?php echo $DispName; ?>" required>
														</div>
													</div>

													<!-- Email -->
													<div class="col-sm-6">
														<div class="form-group">
															<label for="email">Email</label>
															<input type="email" class="form-control mb-4" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Password Change-->
									<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
										<div id="about" class="section about">
											<div class="info">
												<h5 class="">Password Change</h5>
												<div class="row">
													<!-- New Password -->
													<div class="col-sm-6">
														<div class="form-group">
															<label for="newpassword">New Password</label>
															<input type="password" class="form-control mb-4" name="newpassword" id="newpassword" placeholder="New Password (leave blank if no change desired)">
														</div>
													</div>

													<!-- Repeat NewPassword -->
													<div class="col-sm-6">
														<div class="form-group">
															<label for="renewpassword">Repeat New Password</label>
															<input type="password" class="form-control mb-4" name="renewpassword" id="renewpassword" placeholder="Repeat New Password (leave blank if no change desired)">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>

						<div class="account-settings-footer">

							<div class="as-footer-container">
								<!-- Password -->
								<div class="col-sm-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" class="form-control mb-4" name="password" id="password" placeholder="Password (needed for each processing)" required>
									</div>
								</div>
								<button name="save" type="submit" id="multiple-messages" class="btn btn-primary">Save Changes</button>
							</div>

						</div>
					</form>
				</div>

				<div class="footer-wrapper">
					<?php include('include/footer.php'); ?>
				</div>
			</div>
		</div>
		<!--  END CONTENT AREA  -->

	</div>
	<!-- END MAIN CONTAINER -->

	<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
	<script src="<?php echo $Web_URL; ?>assets/js/libs/jquery-3.1.1.min.js"></script>
	<script src="<?php echo $Web_URL; ?>bootstrap/js/popper.min.js"></script>
	<script src="<?php echo $Web_URL; ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $Web_URL; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="<?php echo $Web_URL; ?>assets/js/app.js"></script>

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
	<script>
		tinymce.init({
			selector: '#tiny-editor',
			plugins: 'preview paste importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
			menubar: 'file edit view insert format tools table help',
			toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
			toolbar_mode: 'floating',
			tinycomments_mode: 'embedded',
			skin: "oxide-dark",
			content_css: "dark",
			tinycomments_author: 'Author name',
			height: "580",
		});
	</script>
	<script src="<?php echo $Web_URL; ?>assets/js/custom.js"></script>
	<!-- END GLOBAL MANDATORY SCRIPTS -->

	<!--  BEGIN CUSTOM SCRIPTS FILE  -->

	<script src="<?php echo $Web_URL; ?>plugins/dropify/dropify.min.js"></script>
	<script src="<?php echo $Web_URL; ?>plugins/blockui/jquery.blockUI.min.js"></script>
	<!-- <script src="plugins/tagInput/tags-input.js"></script> -->
	<script src="<?php echo $Web_URL; ?>assets/js/users/account-settings.js"></script>
	<!--  END CUSTOM SCRIPTS FILE  -->
</body>

</html>