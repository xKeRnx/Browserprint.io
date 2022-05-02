<?php
$__TOKEN = "hardcodeshitbykernstudios";
include('includes/config.php');

$activesite = 'bugreport';
if (!isset($_SESSION['ulogin'])) {
    header('location:' . $Web_URL);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('include/head.php'); ?>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/forms/switches.css">
    <link href="<?php echo $Web_URL; ?>plugins/pricing-table/css/component.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $Web_URL; ?>assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo $Web_URL; ?>assets/css/apps/notes.css" rel="stylesheet" type="text/css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- END PAGE LEVEL STYLES -->
</head>

<body class="alt-menu sidebar-noneoverflow">
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

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3>Bugreport</h3>
                    </div>
                </div>

                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>If you find a bug and report it, you help us to improve our projects.</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- CONTENT HERE -->
                            <div class="widget-content widget-content-area">
                                <div class="card component-card_9" style="width: 100%;">
                                    <?php
                                    $error = "0";
                                    $sucs = "0";
                                    if (isset($_POST['send'])) {
                                        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                                            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . google_secret . '&response=' . $_POST['g-recaptcha-response']);
                                            $responseData = json_decode($verifyResponse);
                                            if ($responseData->success) {
                                                if ($send->bugreport($_POST['desc'], $_POST['cate'])) {
                                                    $sucs = "Thanks for reporting a bug.";
                                                    $error = "0";
                                                } else {
                                                    $sucs = "0";
                                                    $error = "Oh something went wrong! Please contact our support";
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

                                    if (@$error != "0") {
                                        echo '<div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">';
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle">';
                                        echo '<circle cx="12" cy="12" r="10"></circle>';
                                        echo '<line x1="12" y1="8" x2="12" y2="12"></line>';
                                        echo '<line x1="12" y1="16" x2="12" y2="16"></line>';
                                        echo '</svg>';
                                        echo $error;
                                        echo '</div>';
                                    } elseif (@$sucs != "0" and @$error == "0") {
                                        echo '<div class="alert alert-arrow-right alert-icon-right alert-light-success mb-4" role="alert">';
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">';
                                        echo '<polyline points="20 6 9 17 4 12"></polyline>';
                                        echo '</svg>';
                                        echo $sucs;
                                        echo ' </div>';
                                    } ?>

                                    <form enctype="multipart/form-data" method="post">
                                        <div class="form-group  mb-4">
                                            <label for="cate">Category</label>
                                            <select id="cate" name="cate" class="form-control">
                                                <option value="0">Website</option>
                                                <option value="1">API</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="desc">Description</label>
                                            <textarea name="desc" class="form-control" id="desc" rows="3" maxlength="999" required=""></textarea>
                                        </div>
                                        <center>
                                            <div class="g-recaptcha" data-sitekey="<?php echo google_public; ?>"></div>
                                        </center>
                                        <input type="submit" name="send" class="btn btn-primary btn-block mt-4 mb-4" value="Report">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-wrapper">
                    <?php include('include/footer.php'); ?>
                </div>

            </div>
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script src="assets/js/dashboard/dash_2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>