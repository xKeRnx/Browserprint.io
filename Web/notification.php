<?php 
$__TOKEN = "hardcodeshitbykernstudios"; 
require($_SERVER["DOCUMENT_ROOT"].'/includes/config.php');

$activesite = 'notification';

if (!isset($_SESSION['ulogin'])) {
    header('location:'.$Web_URL);
	exit();
}else{
    $username = $_SESSION['ulogin'];
    $sql = "SELECT * from users where name = (:username);";
    $query = $dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_OBJ);
    $userID = $result->id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('include/head.php');?>
	<!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>assets/css/forms/switches.css">
    <link href="<?php echo $Web_URL; ?>plugins/pricing-table/css/component.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Web_URL; ?>assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo $Web_URL; ?>assets/css/apps/notes.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $Web_URL; ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $Web_URL; ?>plugins/table/datatable/dt-global_style.css">
    <!-- END PAGE LEVEL STYLES -->
</head>
<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
	<?php include('include/navbar.php');?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
		<?php include('include/topbar.php');?>
        <!--  END TOPBAR  -->
        
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3>Notifications</h3>
                    </div>
                </div>

                <div class="row layout-top-spacing">
					<div class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Here you can see all your notifications</h4>
                                    </div>           
                                </div>
                            </div>
							<!-- CONTENT HERE -->
                            <div class="widget-content widget-content-area">
    	                        <?php
                                    $reciver = $_SESSION['ulogin'];
                                    $sql_log = "SELECT * from  notification where notireciver = (:reciver) OR notiuser= (:reciver) order by time DESC";
                                    $log_query = $dbh -> prepare($sql_log);
                                    $log_query->bindParam(':reciver', $reciver, PDO::PARAM_STR);
                                    $log_query->execute();
                                    $log_ress=$log_query->fetchAll(PDO::FETCH_OBJ);
                                    if($log_query->rowCount() > 0)
                                    {
                                ?>
                                        <div class="table-responsive">
                                        <table id="zero-config" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Username</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                        foreach($log_ress as $log_res)
                                                        {
                                                            $notiuser = $log_res->notiuser;
                                                            $notitype = $log_res->notitype;
                                                            $dDate = $log_res->time;

                                                            $date = date_create($dDate);
												            $date = date_format($date,"m/d/Y H:i:s");
                                                            echo '<tr>';
                                                                echo "<td>$i</td>";
                                                                echo "<td>$notiuser</td>";
                                                                echo "<td>$notitype</td>";
                                                                echo "<td>$date</td>";
                                                            echo '</tr>';
                                                            $i++;
                                                        }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Username</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                <?php
                                    }else{
                                        echo '<div class="alert alert-arrow-right alert-icon-right alert-light-info mb-4" role="alert">';
											echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>';
											echo 'No logs available.';
											echo '';
										echo '</div>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-wrapper">
                <?php include('include/footer.php');?>  
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
    <script>
        $('#zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7 
        });
    </script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>
<?php
}
?>