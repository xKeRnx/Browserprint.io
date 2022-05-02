<?php
$__TOKEN = "hardcodeshitbykernstudios";
require($_SERVER["DOCUMENT_ROOT"] . '/includes/config.php');

$activesite = 'index';
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
	<link href="<?php echo $Web_URL; ?>plugins/noUiSlider/custom-nouiSlider.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $Web_URL; ?>assets/css/plan.css" rel="stylesheet" type="text/css" />

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
						<h3>Dashboard</h3>
					</div>
				</div>

				<div class="row layout-top-spacing">

				<?php
				$allBrowser_cnt = 0;
				$otherBrowser_cnt = 0;
				$chromeBrowser_cnt = 0;
				$firefoxBrowser_cnt = 0;

				$sql = "SELECT COUNT(*) as cnt FROM save_fp WHERE data LIKE '%\"browser\":\"%' AND active_save=1;";
				$query = $dbh->prepare($sql);
				$query->execute();
				if ($query->rowCount() > 0) {
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					$allBrowser_cnt = $res[0]->cnt;
				}

				$sql = "SELECT COUNT(*) as cnt FROM save_fp WHERE data NOT LIKE '%\"browser\":\"Chrome%' AND data NOT LIKE '%\"browser\":\"Firefox%' AND data LIKE '%\"browser\":\"%' AND active_save=1;";
				$query = $dbh->prepare($sql);
				$query->execute();
				if ($query->rowCount() > 0) {
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					$otherBrowser_cnt = $res[0]->cnt;
				}

				$sql = "SELECT COUNT(*) as cnt FROM save_fp WHERE data LIKE '%\"browser\":\"Chrome%' AND active_save=1;";
				$query = $dbh->prepare($sql);
				$query->execute();
				if ($query->rowCount() > 0) {
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					$chromeBrowser_cnt = $res[0]->cnt;
				}

				$sql = "SELECT COUNT(*) as cnt FROM save_fp WHERE data LIKE '%\"browser\":\"Firefox%' AND active_save=1;";
				$query = $dbh->prepare($sql);
				$query->execute();
				if ($query->rowCount() > 0) {
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					$firefoxBrowser_cnt = $res[0]->cnt;
				}

				$chromeBrowser_przt = round(($chromeBrowser_cnt * 100) / $allBrowser_cnt);
				$firefoxBrowser_przt = round(($firefoxBrowser_cnt * 100) / $allBrowser_cnt);
				$otherBrowser_przt = round(($otherBrowser_cnt * 100) / $allBrowser_cnt);

				?>
					
					<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-heading">
                                <h5 class="">Visitors by Browser</h5>
                            </div>
                            <div class="widget-content">
                                <div class="vistorsBrowser">
                                    <div class="browser-list">
                                        <div class="w-icon">
											<i class="fab fa-chrome"></i>
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6>Chrome</h6>
                                                <p class="browser-count"><?php echo $chromeBrowser_przt; ?>%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?php echo $chromeBrowser_przt; ?>%" aria-valuenow="<?php echo $chromeBrowser_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon">
											<i class="fab fa-firefox-browser"></i>
                                        </div>
                                        <div class="w-browser-details">
                                            
                                            <div class="w-browser-info">
                                                <h6>Firefox</h6>
                                                <p class="browser-count"><?php echo $firefoxBrowser_przt; ?>%</p>
                                            </div>

                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?php echo $firefoxBrowser_przt; ?>%" aria-valuenow="<?php echo $firefoxBrowser_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon">
											<i class="fas fa-globe"></i>
                                        </div>
                                        <div class="w-browser-details">
                                            
                                            <div class="w-browser-info">
                                                <h6>Others</h6>
                                                <p class="browser-count"><?php echo $otherBrowser_przt; ?>%</p>
                                            </div>

                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?php echo $otherBrowser_przt; ?>%" aria-valuenow="<?php echo $otherBrowser_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>

					<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-heading">
                                <h5 class="">Visitors by Country</h5>
                            </div>
							<div class="widget-content">
                                <div class="vistorsBrowser">

								<?php
								$cnt_all_country_cnt = 0;
								$cnt_1_country_cnt = 0;
								$cnt_1_country = '';
								$cnt_1_country_code = '';
								$cnt_2_country_cnt = 0;
								$cnt_2_country = '';
								$cnt_2_country_code = '';
								$sql = "SELECT COUNT(*) as cnt FROM krake";
								$query = $dbh->prepare($sql);
								$query->execute();
								if ($query->rowCount() > 0) {
									$res = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt_all_country_cnt = $res[0]->cnt;
								}

								$sql = "SELECT COUNT(Country) as cnt, country, country_code from Krake Group BY Country ORDER BY COUNT(Country) DESC LIMIT 2";
								$query = $dbh->prepare($sql);
								$query->execute();
								if ($query->rowCount() > 0) {
									$res = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt_1_country_cnt = $res[0]->cnt;
									$cnt_1_country = $res[0]->country;
									$cnt_1_country_code = $res[0]->country_code;
									$cnt_2_country_cnt = $res[1]->cnt;
									$cnt_2_country = $res[1]->country;
									$cnt_2_country_code = $res[1]->country_code;
								}

								$cnt_oher_country_cnt = $cnt_all_country_cnt - $cnt_1_country_cnt - $cnt_2_country_cnt;
								$cnt_oher_country_przt = round(($cnt_oher_country_cnt * 100) / $cnt_all_country_cnt);

								$cnt_1_country_przt = round(($cnt_1_country_cnt * 100) / $cnt_all_country_cnt);
								$cnt_2_country_przt = round(($cnt_2_country_cnt * 100) / $cnt_all_country_cnt);
								?>

                                    <div class="browser-list">
                                        <div class="w-icon">
											<img style="width:16px; height:16px;" src="https://browserprint.io/api/flags?i=<?php echo $cnt_1_country_code; ?>">
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6><?php echo $cnt_1_country; ?></h6>
                                                <p class="browser-count"><?php echo $cnt_1_country_przt; ?>%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?php echo $cnt_1_country_przt; ?>%" aria-valuenow="<?php echo $cnt_1_country_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon">
										<img style="width:16px; height:16px;" src="https://browserprint.io/api/flags?i=<?php echo $cnt_2_country_code; ?>">
                                        </div>
                                        <div class="w-browser-details">
                                            
                                            <div class="w-browser-info">
                                                <h6><?php echo $cnt_2_country; ?></h6>
                                                <p class="browser-count"><?php echo $cnt_2_country_przt; ?>%</p>
                                            </div>

                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?php echo $cnt_2_country_przt; ?>%" aria-valuenow="<?php echo $cnt_2_country_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon">
										<img style="width:16px; height:16px;" src="https://browserprint.io/api/flags?i=unk">
                                        </div>
                                        <div class="w-browser-details">
                                            
                                            <div class="w-browser-info">
                                                <h6>Others</h6>
                                                <p class="browser-count"><?php echo $cnt_oher_country_przt; ?>%</p>
                                            </div>

                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?php echo $cnt_oher_country_przt; ?>%" aria-valuenow="<?php echo $cnt_oher_country_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    
                                </div>

                            </div>
						</div>
					</div>

					<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-heading">
                                <h5 class="">Visitors by OS</h5>
                            </div>
							<div class="widget-content">
                                <div class="vistorsBrowser">

								<?php
								$cnt_all_os_cnt = 0;
								$cnt_1_os_cnt = 0;
								$cnt_1_os = '';
								$cnt_2_os_cnt = 0;
								$cnt_2_os = '';

								$sql = "SELECT COUNT(*) as cnt FROM krake";
								$query = $dbh->prepare($sql);
								$query->execute();
								if ($query->rowCount() > 0) {
									$res = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt_all_os_cnt = $res[0]->cnt;
								}

								$sql = "SELECT COUNT(os) as cnt, os from Krake Group BY os ORDER BY COUNT(os) DESC LIMIT 2";
								$query = $dbh->prepare($sql);
								$query->execute();
								if ($query->rowCount() > 0) {
									$res = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt_1_os_cnt = $res[0]->cnt;
									$cnt_1_os = $res[0]->os;

									$cnt_2_os_cnt = $res[1]->cnt;
									$cnt_2_os = $res[1]->os;
								}

								$cnt_oher_os_cnt = $cnt_all_os_cnt - $cnt_1_os_cnt - $cnt_2_os_cnt;
								$cnt_oher_os_przt = round(($cnt_oher_os_cnt * 100) / $cnt_all_os_cnt);

								$cnt_1_os_przt = round(($cnt_1_os_cnt * 100) / $cnt_all_os_cnt);
								$cnt_2_os_przt = round(($cnt_2_os_cnt * 100) / $cnt_all_os_cnt);
								?>

                                    <div class="browser-list">
                                        <div class="w-icon">
											<img style="width:16px; height:16px;" src="https://browserprint.io/api/device?i=<?php echo $cnt_1_os; ?>">
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6><?php echo $cnt_1_os; ?></h6>
                                                <p class="browser-count"><?php echo $cnt_1_os_przt; ?>%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?php echo $cnt_1_os_przt; ?>%" aria-valuenow="<?php echo $cnt_1_os_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon">
										<img style="width:16px; height:16px;" src="https://browserprint.io/api/device?i=<?php echo $cnt_2_os; ?>">
                                        </div>
                                        <div class="w-browser-details">
                                            
                                            <div class="w-browser-info">
                                                <h6><?php echo $cnt_2_os; ?></h6>
                                                <p class="browser-count"><?php echo $cnt_2_os_przt; ?>%</p>
                                            </div>

                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?php echo $cnt_2_os_przt; ?>%" aria-valuenow="<?php echo $cnt_2_os_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon">
										<img style="width:16px; height:16px;" src="https://browserprint.io/api/device?i=unk">
                                        </div>
                                        <div class="w-browser-details">
                                            
                                            <div class="w-browser-info">
                                                <h6>Others</h6>
                                                <p class="browser-count"><?php echo $cnt_oher_os_przt; ?>%</p>
                                            </div>

                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?php echo $cnt_oher_os_przt; ?>%" aria-valuenow="<?php echo $cnt_oher_os_przt; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    
                                </div>

                            </div>
						</div>
					</div>

					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5><img src="<?php echo $Web_URL; ?>assets/img/logo.png" style="height: 40px; margin-right: 20px;">Browser Fingerprinting API</h5>
							</div>
							<div class="widget-content">
								<p>Stop fraud, spam, and account takeovers with 99.5% accurate browser fingerprinting.</p>
								<p>- Advanced Device Fingerprinting & Device Tracking.</p>
								<p>- Browser Fingerprint & Cross Device Tracking</p>
								<p>- Lower Your Chance of Chargebacks, Reversals, Abuse, & Fraudulent Users</p>
								<p>- Detect Duplicate Accounts & Users</p>
								<p>- 4 fingerprints with up to 99.5% accuracy</p>
							</div>
						</div>
					</div>

					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5><img src="<?php echo $Web_URL; ?>assets/img/ip.png" style="height: 40px; margin-right: 20px;">IP Research API</h5>
							</div>
							<div class="widget-content">
								<p>- IP classification.</p>
								<p>- VPN, Proxy and Tor detection.</p>
								<p>- Bot detection.</p>
								<p>- Get the location of any IP city, region, country and lat/long data.</p>
							</div>
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing"> 
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-heading">
                                <h5 class="">Plans</h5>
                            </div>
                            <div class="widget-content">
                                <div class="invoice-box">
								
								<div class="container">
									<div class="row">
										<div class="col-lg-12">
							
										<div id="plan-wrapper">
											<div id="form-plan">
												<h1 id="form-title">Select a Plan</h1>
												<div id="debt-amount-slider">
													<input type="radio" name="debt-amount" id="1" value="1" required>
													<label for="1" data-debt-amount="100k"></label>
													<input type="radio" name="debt-amount" id="2" value="2" required>
													<label for="2" data-debt-amount="200k"></label>
													<input type="radio" name="debt-amount" id="3" value="3" required>
													<label for="3" data-debt-amount="500k"></label>
													<input type="radio" name="debt-amount" id="4" value="4" required>
													<label for="4" data-debt-amount="1M"></label>
													<input type="radio" name="debt-amount" id="5" value="5" required>
													<label for="5" data-debt-amount="2M"></label>
													<div id="debt-amount-pos"></div>
												</div>
											</div>
										</div>
							
											<!-- Pricing Plans Container -->
											<div class="pricing-plans-container mt-5 d-md-flex d-block">
												<!-- Plan -->
												<div class="pricing-plan mb-5">
													<h3>Fingerprinting</h3>
													<p class="margin-top-10">JS Fingerprinting with Device information.</p>
													<br>
													<strong id="qpm1" class="cw">100k queries per day</strong>
													<div class="pricing-plan-label billed-monthly-label"><strong id="p1"><?php echo price100_0; ?>€</strong>/ monthly</div>
													<div class="pricing-plan-features mb-4">
														<strong>Fingerprinting Features</strong>
														<ul>
															<li>Fingerprints</li>
															<li>Device information</li>
														</ul>
													</div>
													<?php
													if (isset($_SESSION['ulogin'])) {
														echo '<a href="'.$Web_URL.'new_project/1" class="button btn btn-primary btn-block margin-top-20">Buy Now</a>';
													}else{
														echo '<a href="'.$Web_URL.'login" class="button btn btn-primary btn-block margin-top-20">Buy Now</a>';
													}
													?>
												</div>
												<!-- Plan -->
												<div class="pricing-plan mb-5 mt-md-0 recommended">
													<div class="recommended-badge">Most Popular</div>
													<h3>Both</h3>
													<p class="margin-top-10">Fingerprinting & IP research combined.</p>
													<br>
													<strong id="qpm2" class="cw">100k queries per day</strong>
													<div class="pricing-plan-label billed-monthly-label"><strong id="p2"><?php echo price100_2; ?>€</strong>/ monthly</div>
													<div class="pricing-plan-features mb-4">
														<strong>Fingerprinting & IP research Features</strong>
														<ul>
															<li>Fingerprints</li>
															<li>Device information</li>
															<li>VPN, Proxy and Tor detection (including Fingerprints)</li>
															<li>IP WhoIs (including Fingerprints)</li>
															<li>IP Classification (including Fingerprints)</li>
														</ul>
													</div>
													<?php
													if (isset($_SESSION['ulogin'])) {
														echo '<a href="'.$Web_URL.'new_project/2" class="button btn btn-primary btn-block margin-top-20">Buy Now</a>';
													}else{
														echo '<a href="'.$Web_URL.'login" class="button btn btn-primary btn-block margin-top-20">Buy Now</a>';
													}
													?>
												</div>
												<!-- Plan -->
												<div class="pricing-plan mb-5">
													<h3>IP research</h3>
													<p class="margin-top-10">IP research with IP Classification, VPN, Proxy and Tor detection.</p>
													<br>
													<strong id="qpm3" class="cw">100k queries per day</strong>
													<div class="pricing-plan-label billed-monthly-label"><strong id="p3"><?php echo price100_1; ?>€</strong>/ monthly</div>
													<div class="pricing-plan-features mb-4">
														<strong>IP research Features</strong>
														<ul>
															<li>VPN, Proxy and Tor detection</li>
															<li>IP WhoIs</li>
															<li>IP Classification</li>
														</ul>
													</div>
													<?php
													if (isset($_SESSION['ulogin'])) {
														echo '<a href="'.$Web_URL.'new_project/3" class="button btn btn-primary btn-block margin-top-20">Buy Now</a>';
													}else{
														echo '<a href="'.$Web_URL.'login" class="button btn btn-primary btn-block margin-top-20">Buy Now</a>';
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>

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

		var labelID;
		$('label').click(function() {
			labelID = $(this).attr('for');
			if(labelID == 1){
				$('#qpm1').html('100k queries per day');
				$('#qpm2').html('100k queries per day');
				$('#qpm3').html('100k queries per day');
				$('#p1').html('<?php echo price100_0; ?>€');
				$('#p2').html('<?php echo price100_2; ?>€');
				$('#p3').html('<?php echo price100_1; ?>€');
			}else if(labelID == 2){
				$('#qpm1').html('200k queries per day');
				$('#qpm2').html('200k queries per day');
				$('#qpm3').html('200k queries per day');
				$('#p1').html('<?php echo price200_0; ?>€');
				$('#p2').html('<?php echo price200_2; ?>€');
				$('#p3').html('<?php echo price200_1; ?>€');
			}else if(labelID == 3){
				$('#qpm1').html('500k queries per day');
				$('#qpm2').html('500k queries per day');
				$('#qpm3').html('500k queries per day');
				$('#p1').html('<?php echo price500_0; ?>€');
				$('#p2').html('<?php echo price500_2; ?>€');
				$('#p3').html('<?php echo price500_1; ?>€');
			}else if(labelID == 4){
				$('#qpm1').html('1M queries per day');
				$('#qpm2').html('1M queries per day');
				$('#qpm3').html('1M queries per day');
				$('#p1').html('<?php echo price1000_0; ?>€');
				$('#p2').html('<?php echo price1000_2; ?>€');
				$('#p3').html('<?php echo price1000_1; ?>€');
			}else if(labelID == 5){
				$('#qpm1').html('2M queries per day');
				$('#qpm2').html('2M queries per day');
				$('#qpm3').html('2M queries per day');
				$('#p1').html('<?php echo price2000_0; ?>€');
				$('#p2').html('<?php echo price2000_2; ?>');
				$('#p3').html('<?php echo price2000_1; ?>€');
			}
			
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