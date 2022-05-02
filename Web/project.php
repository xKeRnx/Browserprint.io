<?php
$__TOKEN = "hardcodeshitbykernstudios";
require $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';

$activesite = 'project';

if (!isset($_SESSION['ulogin'])) {
    header('location:' . $Web_URL);
    exit();
} else {
    $username = $_SESSION['ulogin'];
    $sql = "SELECT * from users where name = (:username);";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $userID = $result->id;
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'include/head.php';?>
	<!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/forms/switches.css">
    <link href="<?php echo $Web_URL; ?>plugins/pricing-table/css/component.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Web_URL; ?>assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo $Web_URL; ?>assets/css/apps/notes.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $Web_URL; ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>plugins/table/datatable/dt-global_style.css">
    <link href="<?php echo $Web_URL; ?>assets/css/components/cards/card.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $Web_URL; ?>assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $Web_URL; ?>assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css">
    <!-- END PAGE LEVEL STYLES -->
</head>
<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
	<?php include 'include/navbar.php';?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
		<?php include 'include/topbar.php';?>
        <!--  END TOPBAR  -->

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <a href="<?php echo $Web_URL; ?>project"><h3>Your Projects</h3></a>
                    </div>
                </div>

                <div class="row layout-top-spacing">
					<div class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <?php
                                     if(isset($_GET['i']) && $_GET['i'] != "" && isset($_GET['s']) && $_GET['s'] == "edit"){
                                        echo '<h4>Here you can edit your project</h4>';
                                     }elseif(isset($_GET['i']) && $_GET['i'] != "" && isset($_GET['s']) && $_GET['s'] == "upgrade"){
                                        echo '<h4>Here you can upgrade or downgrade your project</h4>';
                                     }elseif(isset($_GET['i']) && $_GET['i'] != "" && isset($_GET['s']) && $_GET['s'] == "statistics"){
                                        echo '<h4>Here you can see your Statisitics</h4>';
                                     }else{
                                        echo '<h4>Here you can see all your projects</h4>';
                                     }
                                    ?>
                                    </div>
                                </div>
                            </div>
							<!-- CONTENT HERE -->
                            <div class="widget-content widget-content-area centcard">
    	                        <?php
                                if(isset($_GET['i']) && $_GET['i'] != "" && isset($_GET['s']) && $_GET['s'] == "edit"){
                                    $id = $_GET['i'];
                                    $users->editProjectByID($userID, $id);
                                }elseif(isset($_GET['i']) && $_GET['i'] != "" && isset($_GET['s']) && $_GET['s'] == "upgrade"){
                                    $id = $_GET['i'];
                                    $users->upgradeProjectByID($userID, $id);
                                }elseif(isset($_GET['i']) && $_GET['i'] != "" && isset($_GET['s']) && $_GET['s'] == "statistics"){
                                    $id = $_GET['i'];
                                    $users->getStatisticsByID($userID, $id);
                                }else{
                                    $users->getProjectByUserID($userID);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-wrapper">
                <?php include 'include/footer.php';?>
                </div>

            </div>
        </div>
        <!--  END CONTENT PART  -->

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
    <script src="<?php echo $Web_URL; ?>assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="<?php echo $Web_URL; ?>plugins/apex/apexcharts.min.js"></script>
    <script src="<?php echo $Web_URL; ?>assets/js/dashboard/dash_2.js"></script>
    <script src="<?php echo $Web_URL; ?>plugins/table/datatable/datatables.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>
<?php
}
?>