<?php 
$__TOKEN = "hardcodeshitbykernstudios"; 
require($_SERVER["DOCUMENT_ROOT"].'/includes/config.php');

$activesite = 'news';
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
	<link href="<?php echo $Web_URL; ?>assets/css/components/custom-carousel.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $Web_URL; ?>assets/css/components/cards/card.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $Web_URL; ?>assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
	
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
                        <h3>News</h3>
                    </div>
                </div>

                <div class="row layout-top-spacing">
					<!-- News -->
					<div class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>News</h4>
                                    </div>           
                                </div>
                            </div>
							<div class="widget-content widget-content-area">
								<div id="toggleAccordion">

								<?php
                                    $sql_news = "SELECT * from news ORDER BY dDate DESC";
                                    $news_query = $dbh -> prepare($sql_news);
                                    $news_query->execute();
                                    $news_ress=$news_query->fetchAll(PDO::FETCH_OBJ);
                                    if($news_query->rowCount() > 0)
                                    {
										$i = 0;
										foreach($news_ress as $news_res)
										{
											$id = $news_res->id;
											$title = $news_res->Title;
											$Description = $news_res->Description;
											$dDate = $news_res->dDate;
											$date = date_create($dDate);
											$date = date_format($date,"m/d/Y");

											$show = '';
											$colapse = 'collapsed';
											if($i == 0){
												$show = 'show';
												$colapse = '';
											}
											echo '<div class="card">';
											echo '<div class="card-header" id="heading'.$id.'">';
											echo '<section class="mb-0 mt-0">';
											echo '<div role="menu" class="'.$colapse.'" data-toggle="collapse" data-target="#defaultAccordion'.$id.'" aria-expanded="true" aria-controls="defaultAccordionOne">';
											echo $title.' - '.$date.'<div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>';
											echo '</div>';
											echo '</section>';
											echo '</div>';
		
											echo '<div id="defaultAccordion'.$id.'" class="collapse '.$show.'" aria-labelledby="heading'.$id.'" data-parent="#toggleAccordion">';
											echo '<div class="card-body">';
											echo base64_decode($Description);
											echo '</div>';
											echo '</div>';
											echo '</div>';
											$i++;
										}
									}else{
 										echo '<div class="alert alert-arrow-right alert-icon-right alert-light-info mb-4" role="alert">';
											echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>';
											echo 'No news available.';
											echo '';
										echo '</div>';
									}
                                ?>
                                </div>
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
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>