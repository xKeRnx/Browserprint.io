<?php
$__TOKEN = "hardcodeshitbykernstudios";
require $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';

$activesite = 'whois';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'include/head.php'; ?>
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
	<?php include 'include/navbar.php'; ?>
	<!--  END NAVBAR  -->

	<!--  BEGIN MAIN CONTAINER  -->
	<div class="main-container" id="container">

		<div class="overlay"></div>
		<div class="search-overlay"></div>

		<!--  BEGIN TOPBAR  -->
		<?php include 'include/topbar.php'; ?>
		<!--  END TOPBAR  -->

		<!--  BEGIN CONTENT PART  -->
		<div id="content" class="main-content">
			<div class="layout-px-spacing">

				<div class="page-header">
					<div class="page-title">
						<h3>WhoIs</h3>
					</div>
				</div>

				<?php
				$error = false;
				if (isset($_GET['i']) and $_GET['i'] != "") {
					$domain = $_GET['i'];
				} else {
					$domain = $fp->getIP();
				}
				?>

				<div class="row layout-top-spacing">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5 class="">FREE WhoIS</h5>
							</div>
							<div class="widget-content">
								<div class="invoice-box">
									<div class="acc-total-info">
										<div class="input-group mb-4">
											<input id="sip" type="text" class="form-control" placeholder="Domain/IP Address" value="<?php echo $domain; ?>" aria-label="Enter Domain/IP Address">
											<div class="input-group-append">
												<button id="sbtn" class="btn btn-primary" type="button">Search</button>
											</div>
										</div>
									</div>
									
									<?php
										if($domain) {
											$domain = trim($domain);
											if(substr(strtolower($domain), 0, 7) == "http://") $domain = substr($domain, 7);
											if(substr(strtolower($domain), 0, 4) == "www.") $domain = substr($domain, 4);
											if($check->ValidateIP($domain)) {
												$result = $check->LookupIP($domain);
											}
											elseif($check->ValidateDomain($domain)) {
												$result = $check->LookupDomain($domain);
											}
											else
											{
												$error = true;
											}	
										}
									?>
									<div class="code-section-container show-code">
									<?php
									if($error == false){
									?>
										<div class="code-section text-left">
											<pre class="hljs javascript">
												<?php echo "<pre class=\"hljs javascript\">\n" . $result . "\n</pre>\n"; ?>
											<pre>
										</div>
									</div>
									<?php 
									}else{
										echo $alert->error('Wrong Domain/IP Address'); 
									}
									?>

								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="footer-wrapper">
					<?php include 'include/footer.php'; ?>
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

		$(function() {
			$("#sbtn").click( function()
				{
					var getUrl = window.location;
					var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
					var newURL = baseUrl+ "/" +$('#sip').val();
					$(location).attr('href',newURL);
				}
			);
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