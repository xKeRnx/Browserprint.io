<?php
$__TOKEN = "hardcodeshitbykernstudios";
require $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';

$activesite = 'free';
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
						<h3>FREE API</h3>
					</div>
				</div>

				<div class="row layout-top-spacing">

					<div class="col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					<?php echo $alert->info('Free API for commercial purposes and without limitation is available for 4€/mon.'); ?>
					</div>

					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5 class="">FREE API Demo</h5>
							</div>
							<div class="widget-content">
								<div class="invoice-box">
									<?php
									if (isset($_GET['i']) and $_GET['i'] != "") {
										$ip = $_GET['i'];
									} else {
										$ip = $fp->getIP();
									}
									?>

									<div class="acc-total-info">
										<div class="input-group mb-4">
											<input id="sip" type="text" class="form-control" placeholder="Enter IP" value="<?php echo $ip; ?>" aria-label="Enter IP">
											<div class="input-group-append">
												<button id="sbtn" class="btn btn-primary" type="button">Search</button>
											</div>
										</div>
									</div>

									<div class="inv-detail">
										<?php

											$ch = curl_init("https://browserprint.io/api/free?ip=".$ip);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											$result = curl_exec($ch);
											curl_close($ch);
											$obj = json_decode($result, true);

											if($obj['status'] == "OK"){
												echo '<div class="info-detail-1"><p>IP</p><p class="wi40">' . $obj['ip'] . '</p></div>';
												echo '<div class="info-detail-1"><p>Country</p><p class="wi40">' . $obj['country'] . '</p></div>';
												echo '<div class="info-detail-1"><p>City</p><p class="wi40">' . $obj['city'] . '</p></div>';
												echo '<div class="info-detail-1"><p>Region</p><p class="wi40">' . $obj['region'] . '</p></div>';
												echo '<div class="info-detail-1"><p>Postal</p><p class="wi40">' . $obj['zip'] . '</p></div>';
												echo '<div class="info-detail-1"><p>Latitude</p><p class="wi40">' . $obj['lat'] . '</p></div>';
												echo '<div class="info-detail-1"><p>Longitude</p><p class="wi40">' . $obj['long'] . '</p></div>';
												
											}else{
												$alert->info($obj['status']);
											}
										?>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5 class="">FREE API</h5>
							</div>
							<div class="widget-content">
								<div class="invoice-box">

									<div class="code-section-container show-code">
										<div class="code-section text-left">
											<pre class="hljs javascript">

											<pre class="hljs" style="overflow: hidden;width: 900px;"><span class="xml"><span class="php"><span class="hljs-meta" style="color: rgb(252, 155, 155);">&lt;?php</span>
	<span class="hljs-function">
	$ip = <span class="hljs-string" style="color: rgb(162, 252, 162);">"USER IP"</span>;

	<span class="hljs-string" style="color: rgb(162, 252, 162);">//Free usage:</span>
	$url = <span class="hljs-string" style="color: rgb(162, 252, 162);">"https://browserprint.io/api/free?ip="</span>.$ip;

	<span class="hljs-string" style="color: rgb(162, 252, 162);">//Comercial usage:</span>
	$key = <span class="hljs-string" style="color: rgb(162, 252, 162);">"YOUR KEY"</span>;
	$url = <span class="hljs-string" style="color: rgb(162, 252, 162);">"https://browserprint.io/api/free?ip="</span>.$ip.<span class="hljs-string" style="color: rgb(162, 252, 162);">"&key="</span>.$key;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result, true);

	<span class="hljs-keyword" style="color: rgb(252, 194, 140);">if</span>($obj['status'] == <span class="hljs-string" style="color: rgb(162, 252, 162);">"OK"</span>){
		<span class="hljs-keyword" style="color: rgb(252, 194, 140);">echo</span> <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;div class="info-detail-1"&gt;&lt;p&gt;IP&lt;/p&gt;&lt;p class="wi40"&gt;'</span> . $obj['ip'] . <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;/p&gt;&lt;/div&gt;'</span>;
		<span class="hljs-keyword" style="color: rgb(252, 194, 140);">echo</span> <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;div class="info-detail-1"&gt;&lt;p&gt;Country&lt;/p&gt;&lt;p class="wi40"&gt;'</span> . $obj['country'] . <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;/p&gt;&lt;/div&gt;'</span>;
		<span class="hljs-keyword" style="color: rgb(252, 194, 140);">echo</span> <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;div class="info-detail-1"&gt;&lt;p&gt;City&lt;/p&gt;&lt;p class="wi40"&gt;'</span> . $obj['cit<'] . <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;/p&gt;&lt;/div&gt;'</span>;
		<span class="hljs-keyword" style="color: rgb(252, 194, 140);">echo</span> <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;div class="info-detail-1"&gt;&lt;p&gt;Region&lt;/p&gt;&lt;p class="wi40"&gt;'</span> . $obj['region'] . <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;/p&gt;&lt;/div&gt;'</span>;
		<span class="hljs-keyword" style="color: rgb(252, 194, 140);">echo</span> <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;div class="info-detail-1"&gt;&lt;p&gt;Latitude&lt;/p&gt;&lt;p class="wi40"&gt;'</span> . $obj['lat'] . <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;/p&gt;&lt;/div&gt;'</span>;
		<span class="hljs-keyword" style="color: rgb(252, 194, 140);">echo</span> <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;div class="info-detail-1"&gt;&lt;p&gt;Longitude&lt;/p&gt;&lt;p class="wi40"&gt;'</span> . $obj['long'] . <span class="hljs-string" style="color: rgb(162, 252, 162);">'&lt;/p&gt;&lt;/div&gt;'</span>;
		
	}<span class="hljs-keyword" style="color: rgb(252, 194, 140);">else</span>{
		$alert-&gt;info($obj['status']);
	}
<span class="hljs-meta" style="color: rgb(252, 155, 155);">?&gt;</span></span></span></pre>

											<pre>
										</div>
									</div>

									<div class="code-section-container show-code">
										<div class="code-section text-left">
											<pre class="hljs javascript">
<?php print_r($obj); ?>
											<pre>
										</div>
									</div>


								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5 class="">Returned data</h5>
							</div>
							<div class="widget-content">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped mb-4">
										<thead>
											<tr>
												<th>Name</th>
												<th>Description</th>
												<th>Example</th>
												<th>Type</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>status</td>
												<td>OK, IP Range Problem</td>
												<td>OK</td>
												<td>string</td>
											</tr>

											<tr>
												<td>error</td>
												<td>
												included only when <strong>status is not OK.</strong>
												<br>Can be one of the following: 255.
												<br>255="IP Range Problem"
												</td>
												<td>255</td>
												<td>int</td>
											</tr>

											<tr>
												<td>ip</td>
												<td>IP used for the query</td>
												<td>67.195.115.105</td>
												<td>string</td>
											</tr>

											<tr>
												<td>country</td>
												<td>Country Name</td>
												<td>United States</td>
												<td>string</td>
											</tr>

											<tr>
												<td>country_code</td>
												<td>Country code</td>
												<td>US</td>
												<td>string</td>
											</tr>

											<tr>
												<td>continent_code</td>
												<td>Two-letter continent code</td>
												<td>NA</td>
												<td>string</td>
											</tr>

											<tr>
												<td>city</td>
												<td>City</td>
												<td>New York</td>
												<td>string</td>
											</tr>

											<tr>
												<td>region</td>
												<td>Region</td>
												<td>New York</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>zip</td>
												<td>Zip code</td>
												<td>10003</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>lat</td>
												<td>Latitude</td>
												<td>40.7306</td>
												<td>float</td>
											</tr>
											
											<tr>
												<td>long</td>
												<td>Longitude</td>
												<td>-73.9915</td>
												<td>float</td>
											</tr>
											
										</tbody>
									</table>
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