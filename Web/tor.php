<?php
$__TOKEN = "hardcodeshitbykernstudios";
require($_SERVER["DOCUMENT_ROOT"] . '/includes/config.php');

$activesite = 'tor';
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
	<link href="<?php echo $Web_URL; ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Web_URL; ?>assets/css/components/custom-carousel.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $Web_URL; ?>assets/css/components/cards/card.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $Web_URL; ?>assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Web_URL; ?>assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />

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

				<div class="row layout-top-spacing">

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing"> 
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-heading">
                                <h5 class="">Tor IPs Example</h5>
                            </div>
                            <div class="widget-content">
                                <div class="invoice-box"><div class="code-section-container show-code"><div class="code-section text-left">
<pre class="hljs javascript"><span style='color:#f6c1d0;'>&lt;?php</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>$ip</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#00c4c4;'>'100.12.176.228'</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>$torResponse</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#e66170;font-weight:bold; '>file_get_contents</span><span style='color:#d2cd86;'>(</span><span style='color:#00c4c4;'>'https://browserprint.io/torlist'</span><span style='color:#d2cd86;'>)</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>$torResponse_exit</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#e66170;font-weight:bold; '>file_get_contents</span><span style='color:#d2cd86;'>(</span><span style='color:#00c4c4;'>'https://browserprint.io/torexitlist'</span><span style='color:#d2cd86;'>)</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'></span>
<span style='color:#e66170;font-weight:bold; '>if</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>(</span><span style='color:#e66170;font-weight:bold; '>strpos</span><span style='color:#d2cd86;'>(</span><span style='color:#ffffff;'>$torResponse_exit</span><span style='color:#d2cd86;'>,</span><span style='color:#ffffff;'> </span><span style='color:#ffffff;'>$ip</span><span style='color:#d2cd86;'>)</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>!</span><span style='color:#d2cd86;'>=</span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#0f4d75;'>false</span><span style='color:#d2cd86;'>)</span><span style='color:#ffffff;'> </span><span style='color:#b060b0;'>{</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>	</span><span style='color:#ffffff;'>$classification</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#00c4c4;'>'Tor exit node'</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>	</span><span style='color:#ffffff;'>$tordetect</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#00c4c4;'>'true'</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#b060b0;'>}</span><span style='color:#e66170;font-weight:bold; '>elseif</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>(</span><span style='color:#e66170;font-weight:bold; '>strpos</span><span style='color:#d2cd86;'>(</span><span style='color:#ffffff;'>$torResponse</span><span style='color:#d2cd86;'>,</span><span style='color:#ffffff;'> </span><span style='color:#ffffff;'>$ip</span><span style='color:#d2cd86;'>)</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>!</span><span style='color:#d2cd86;'>=</span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#0f4d75;'>false</span><span style='color:#d2cd86;'>)</span><span style='color:#ffffff;'> </span><span style='color:#b060b0;'>{</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>	</span><span style='color:#ffffff;'>$classification</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#00c4c4;'>'Tor node'</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#ffffff;'>	</span><span style='color:#ffffff;'>$tordetect</span><span style='color:#ffffff;'> </span><span style='color:#d2cd86;'>=</span><span style='color:#ffffff;'> </span><span style='color:#00c4c4;'>'true'</span><span style='color:#b060b0;'>;</span><span style='color:#ffffff;'></span>
<span style='color:#b060b0;'>}</span><span style='color:#ffffff;'></span>
<span style='color:#f6c1d0;'>?></span>
</pre>
                                </div></div></div>
                            </div>
                        </div>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing"> 
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-heading">
                                <h5 class="">Tor IPs</h5>
                            </div>
                            <div class="widget-content">
                                <div class="invoice-box">
									<?php
									date_default_timezone_set('Europe/Berlin');
										$torlist_file = torlist;
										if(file_exists($torlist_file)){
											echo 'Torlist in txt format (complete) -> <a href="https://browserprint.io/torlist" target="_blank">Click here</a>';
											echo '<br>';
											echo 'Torlist in txt format (exit nodes) -> <a href="https://browserprint.io/torexitlist" target="_blank">Click here</a>';
											echo '<br>';
											echo 'Last update: '.date ("F d Y H:i.", filemtime($torlist_file)).'<br><br>';
											echo nl2br(file_get_contents($torlist_file));
										}else{
											$alert->info('ERROR');
										}
									?>
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
	<script src="<?php echo $Web_URL; ?>assets/js/libs/jquery-3.5.1.min.js"></script>
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