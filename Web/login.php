<?php
require_once('includes/config.php');

if (isset($_SESSION['ulogin'])) {
    header('location:' . $Web_URL);
}
$error = "0";
$sucs = "0";
if (isset($_POST['login'])) {

    $status = '1';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT name,password FROM users WHERE name=:username and status=(:status) OR email=:username and status=(:status)";

    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();

    $results = $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_LAST);

    if ($query->rowCount() == 1) {

        $hashed_password = $results[1];
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . google_secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                if (password_verify($password, $hashed_password)) {
                    $notitype = 'has logged in IP:' . $send->getRemoteIP();
                    $reciver = 'Admin';
                    $sender =  $results[0];

                    $sqlnoti = "insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
                    $querynoti = $dbh->prepare($sqlnoti);
                    $querynoti->bindParam(':notiuser', $sender, PDO::PARAM_STR);
                    $querynoti->bindParam(':notireciver', $reciver, PDO::PARAM_STR);
                    $querynoti->bindParam(':notitype', $notitype, PDO::PARAM_STR);
                    $querynoti->execute();

                    $sucs = "Successfully logged in";
                    $_SESSION['ulogin'] = $results[0];
                    echo "<script type='text/javascript'> document.location = '" . $Web_URL . "'; </script>";
                } else {
                    $sucs = "0";
                    $error = "Invalid Details Or Account not Confirmed";
                }
            } else {
                $sucs = "0";
                $error = "Robot verification failed, please try again.";
            }
        } else {
            $sucs = "0";
            $error = "Please do the robot verification.";
        }
    } else {
        $sucs = "0";
        $error = "Invalid Details Or Account not Confirmed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $_SERVERNAME; ?> - Login</title>
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

                        <h1 class=""><a href="<?php echo $Web_URL; ?>"><span class="brand-name"><?php echo $_SERVERNAME; ?></span></a> LogIn</h1>
                        <p class="signup-link">New Here? <a href="register">Create an account</a></p>
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
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username OR Email" value="<?php echo @$_POST['username']; ?>" required>
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                                </div>
                                <center>
                                    <div class="g-recaptcha" data-sitekey="<?php echo google_public; ?>"></div>
                                </center><br><br>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button name="login" type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>

                                </div>

                                <div class="field-wrapper">
                                    <a href="<?php echo $Web_URL; ?>pwreset" class="forgot-pass-link">Forgot Password?</a>
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