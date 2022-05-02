<?php
require_once('includes/config.php');

if (isset($_SESSION['ulogin'])) {
    header('location:' . $Web_URL);
}
$error = "0";
$sucs = "0";
if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $rpassword = $_POST['reppassword'];
    $chbx = $_POST['chbx'];
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . google_secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) {
            if ($chbx != "ok") {
                $sucs = "0";
                $error = "You must accept our terms and conditions.";
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $sucs = "0";
                    $error = "$email is not a valid email address";
                } elseif ($check->trashmail($email) == true) {
                    $sucs = "0";
                    $error = "Throw away email addresses are not allowed";
                } else {
                    if ($error == "0") {
                        if ($password !== $rpassword) {
                            $sucs = "0";
                            $error = "Passwords do not match!";
                        } else {
                            $sql = "SELECT count(*) FROM users WHERE name=(:username) OR email=(:email)";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':username', $name, PDO::PARAM_STR);
                            $query->bindParam(':email', $email, PDO::PARAM_STR);
                            $query->execute();
                            $number_of_rows = $query->fetchColumn();

                            if ($number_of_rows == 0) {
                                $error = "0";
                                $password = password_hash($password, PASSWORD_DEFAULT);
                                $token = md5($name . base64_encode(random_bytes(32)));

                                $notitype = 'Create Account';
                                $reciver = 'Admin';
                                $sender = $name;

                                $sqlnoti = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
                                $querynoti = $dbh->prepare($sqlnoti);
                                $querynoti->bindParam(':notiuser', $sender, PDO::PARAM_STR);
                                $querynoti->bindParam(':notireciver', $reciver, PDO::PARAM_STR);
                                $querynoti->bindParam(':notitype', $notitype, PDO::PARAM_STR);
                                $querynoti->execute();

                                $sql = "INSERT INTO users(name,dispname,email, password, status, token) VALUES(:name, :dispname, :email, :password, 0, :token)";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':name', $name, PDO::PARAM_STR);
                                $query->bindParam(':dispname', $name, PDO::PARAM_STR);
                                $query->bindParam(':email', $email, PDO::PARAM_STR);
                                $query->bindParam(':password', $password, PDO::PARAM_STR);
                                $query->bindParam(':token', $token, PDO::PARAM_STR);

                                if ($query->execute()) {
                                    if ($send->sendactivate($name, $email) == true) {
                                        $_POST = array();
                                        $sucs = "Registration Successful! <br> We have sent you an email with the activation link.";
                                    } else {
                                        $sucs = "0";
                                        $error = "Email can not be sent, please contact our support";
                                    }
                                } else {
                                    $sucs = "0";
                                    $error = "Something went wrong. Please try again";
                                }
                            } else {
                                $sucs = "0";
                                $error = "Username or Email already exists!";
                            }
                        }
                    }
                }
            }
        } else {
            $sucs = "0";
            $error = "Robot verification failed, please try again.";
        }
    } else {
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
    <title><?php echo $_SERVERNAME; ?> - Register</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
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

                        <h1 class="">Get started with a <br /> free account</h1>
                        <p class="signup-link">Already have an account? <a href="login">Log in</a></p>
                        <form class="text-left" method="post">
                            <div class="form">
                                <?php if (@$error != "0") { ?>
                                    <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12" y2="16"></line>
                                        </svg>
                                        <?php echo $error; ?>
                                    </div>

                                <?php } elseif (@$sucs != "0" and @$error == "0") { ?>
                                    <div class="alert alert-arrow-right alert-icon-right alert-light-success mb-4" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <?php echo $sucs; ?>
                                    </div>
                                <?php } ?>

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="<?php echo @$_POST['username']; ?>" required>
                                </div>
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                    </svg>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="<?php echo @$_POST['email']; ?>" required>
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="password" type="password" value="" placeholder="Password" required>
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="reppassword" name="reppassword" type="password" value="" placeholder="Repeat Password" required>
                                </div>
                                <center>
                                    <div class="g-recaptcha" data-sitekey="<?php echo google_public; ?>"></div>
                                </center><br><br>
                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                            <input id="chbx" name="chbx" type="checkbox" class="new-control-input" value="ok">
                                            <span class="new-control-indicator"></span><span>I agree to the <a href="terms"> terms and conditions </a></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button name="submit" type="submit" class="btn btn-primary" value="">Get Started!</button>
                                    </div>
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
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-1.js"></script>

</body>

</html>