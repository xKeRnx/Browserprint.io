<?php
$__TOKEN = "hardcodeshitbykernstudios";
require($_SERVER["DOCUMENT_ROOT"] . '/includes/config.php');

$activesite = 'fp';
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

				<div class="page-header">
					<div class="page-title">
						<h3>Dashboard</h3>
					</div>
				</div>

				<div class="row layout-top-spacing">
					
					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing"> 
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-heading">
                                <h5 class="">Demo</h5>
                            </div>
                            <div class="widget-content">
                                <div class="invoice-box">
								
                                    <div class="acc-total-info">
                                        <h5>IP</h5>
                                        <p id="ip" class="acc-amount"></p>
                                    </div>
									
                                    <div class="inv-detail">     
										<div class="info-detail-1">
                                            <p>Fingerprint 1</p>
                                            <p class="wi40" id="fp1"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Fingerprint 2</p>
                                            <p class="wi40" id="fp2"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Fingerprint 3</p>
                                            <p class="wi40" id="fp3"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Fingerprint 4</p>
                                            <p class="wi40" id="fp4"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Classification</p>
                                            <p class="wi40" id="classification"></p>
                                        </div> 

										<div class="info-detail-1">
                                            <p>VPN</p>
                                            <p class="wi40" id="vpn"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Proxy</p>
                                            <p class="wi40" id="proxy"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Tor</p>
                                            <p class="wi40" id="tor"> </p>
                                        </div>
									
										<div class="info-detail-1">
                                            <p>Country</p>
                                            <p class="wi40" id="Country"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>City</p>
                                            <p class="wi40" id="City"> </p>
                                        </div>
									
										<div class="info-detail-1">
                                            <p>Region</p>
                                            <p class="wi40" id="Region"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Zip</p>
                                            <p class="wi40" id="Zip"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Latitude</p>
                                            <p class="wi40" id="Lat"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Longitude</p>
                                            <p class="wi40" id="Lon"></p>
                                        </div>
									
                                        <div class="info-detail-1">
                                            <p>OS</p>
                                            <p class="wi40" id="OS"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Browser</p>
                                            <p class="wi40" id="Browser"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Language</p>
                                            <p class="wi40" id="Lang"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Screen</p>
                                            <p class="wi40" id="Screen"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Mobile</p>
                                            <p class="wi40" id="Mobile"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Cookies</p>
                                            <p class="wi40" id="Cookies"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Touch</p>
                                            <p class="wi40" id="Touch"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>Plugins</p>
                                            <p class="wi40" id="Plugins"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>CPU Threads</p>
                                            <p class="wi40" id="CPU"></p>
                                        </div>
										
										<div class="info-detail-1">
                                            <p>GPU</p>
                                            <p class="wi40" id="GPU"></p>
                                        </div>

										<div class="info-detail-1">
                                            <p>Useragent</p>
                                            <p class="wi40" id="UA"></p>
                                        </div>
									
                                    </div>
									
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
						<div class="widget widget-account-invoice-one">
							<div class="widget-heading">
								<h5 class="">BrowserPrinting API</h5>
							</div>
							<div class="widget-content">
								<div class="invoice-box">

									<div class="code-section-container show-code">
										<div class="code-section text-left">
											<pre class="hljs javascript">
											<pre class="hljs" style="overflow: hidden;width: 500px;"><span class="xml"><span class="hljs-tag" style="color: rgb(220, 57, 88);">&lt;<span class="hljs-name" style="color: rgb(220, 57, 88);">script</span> <span class="hljs-attr">src</span>=<span class="hljs-string" style="color: rgb(136, 155, 74);">"https://browserprint.io/api/fp.js"</span>&gt;</span><span class="undefined"></span><span class="hljs-tag" style="color: rgb(220, 57, 88);">&lt;/<span class="hljs-name" style="color: rgb(220, 57, 88);">script</span>&gt;</span>
<span class="hljs-tag" style="color: rgb(220, 57, 88);">&lt;<span class="hljs-name" style="color: rgb(220, 57, 88);">script</span>&gt;</span><span class="javascript">
    <span class="hljs-keyword" style="color: rgb(152, 103, 106);">var</span> BPL = initBP(<span class="hljs-string" style="color: rgb(136, 155, 74);">"YOUR_KEY"</span>);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#ip"</span>).html(BPL.ip);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#vpn"</span>).html(BPL.vpn);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#proxy"</span>).html(BPL.proxy);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#tor"</span>).html(BPL.tor);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Country"</span>).html(BPL.country);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#City"</span>).html(BPL.city);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Region"</span>).html(BPL.region);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Zip"</span>).html(BPL.zip);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Lat"</span>).html(BPL.lat);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Lon"</span>).html(BPL.lon);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#classification"</span>).html(BPL.classification);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#OS"</span>).html(BPL.os);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Screen"</span>).html(BPL.screen);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Browser"</span>).html(BPL.browser);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Mobile"</span>).html(BPL.mobile);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Cookies"</span>).html(BPL.cookies);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#GPU"</span>).html(BPL.getWebGLRenderer);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#CPU"</span>).html(BPL.hwc);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Lang"</span>).html(BPL.lang);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Touch"</span>).html(BPL.getTouchCompatibility);
    $(<span class="hljs-string" style="color: rgb(136, 155, 74);">"#Plugins"</span>).html(BPL.plugin);
</span><span class="hljs-tag" style="color: rgb(220, 57, 88);">&lt;/<span class="hljs-name" style="color: rgb(220, 57, 88);">script</span>&gt;</span></span></pre>

											<pre>
										</div>
									</div>

									<div class="code-section-container show-code">
										<div class="code-section text-left">
											<pre class="hljs javascript" id="priBPL"> 
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
												<td>OK, Plan identifications already exceeded, Project already expired, Key not for this Type, Wrong Website, Key not found in DB, Key not defined</td>
												<td>OK</td>
												<td>string</td>
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
											
											<tr>
												<td>proxy</td>
												<td>Is proxy, Yes or No</td>
												<td>No</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>tor</td>
												<td>Is tor, Yes or No</td>
												<td>No</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>vpn</td>
												<td>Is vpn, Yes or No</td>
												<td>No</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>classification</td>
												<td>IP classification can be:
												<br>Tor exit node, Fake crawler, Known attack source - HTTP, Cgi proxy, Anonymizing VPN service, Web proxy, Web scraper, Known attack source - SSH, Known attack source - MAIL, Crawler, Tor node, Dedicated Server, Unknown
												</td>
												<td>Crawler</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>os</td>
												<td>Operating system</td>
												<td>Windows 10</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>screen</td>
												<td>Screen Width, Screen Height and Screen Color Depth</td>
												<td>1920 x 1080 x 24</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>browser</td>
												<td>Browser name and version</td>
												<td>Chrome 89.0.4389.82</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>mobile</td>
												<td>Is mobile true or false</td>
												<td>false</td>
												<td>bool</td>
											</tr>
											
											<tr>
												<td>cookies</td>
												<td>Cookies enabled true or false</td>
												<td>true</td>
												<td>bool</td>
											</tr>
											
											<tr>
												<td>getWebGLRenderer</td>
												<td>Graphics card</td>
												<td>ANGLE (NVIDIA GeForce GTX 980M Direct3D11 vs_5_0 ps_5_0)</td>
												<td>string</td>
											</tr>
											
											<tr>
												<td>hwc</td>
												<td>CPU cores</td>
												<td>8</td>
												<td>int</td>
											</tr>

											<tr>
												<td>lang</td>
												<td>System language</td>
												<td>de</td>
												<td>string</td>
											</tr>

											<tr>
												<td>getTouchCompatibility</td>
												<td>Tochscreen available true or false</td>
												<td>false</td>
												<td>bool</td>
											</tr>

											<tr>
												<td>plugin</td>
												<td>Available plugin</td>
												<td>Chrome PDF Plugin, Chrome PDF Viewer, Native Client</td>
												<td>string</td>
											</tr>

											<tr>
												<td>ua</td>
												<td>Useragent</td>
												<td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36</td>
												<td>string</td>
											</tr>

											<tr>
												<td>fp1</td>
												<td>Fingerprint with 99.5% accuracy</td>
												<td>cfd741eac6956e1390b2adda59330d37</td>
												<td>string</td>
											</tr>

											<tr>
												<td>fp2</td>
												<td>Fingerprint with 60% accuracy</td>
												<td>d053bfe7fabfb43518ca420f63dfe14e</td>
												<td>string</td>
											</tr>

											<tr>
												<td>fp3</td>
												<td>Fingerprint with 55% accuracy</td>
												<td>38aad2faa451dc7a94e5c790abf21eb7t</td>
												<td>string</td>
											</tr>

											<tr>
												<td>fp4</td>
												<td>Fingerprint with 90% accuracy</td>
												<td>1198b2b328f509d4cf83682839b416f4</td>
												<td>string</td>
											</tr>
										</tbody>
									</table>
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
	<script src="<?php echo $Web_URL; ?>api/fp.js"></script>
	<script>
		var BPL = initBP('b1fd56c05c0cf75b16d95c23a944680b');
		$("#ip").html(BPL.ip);
		$("#vpn").html(BPL.vpn);
		$("#proxy").html(BPL.proxy);
		$("#tor").html(BPL.tor);
		$("#Country").html(BPL.country);
		$("#City").html(BPL.city);
		$("#Region").html(BPL.region);
		$("#Zip").html(BPL.zip);
		$("#Lat").html(BPL.lat);
		$("#Lon").html(BPL.lon);
		$("#classification").html(BPL.classification);
		$("#OS").html(BPL.os);
		$("#Screen").html(BPL.screen);
		$("#Browser").html(BPL.browser);
		$("#Mobile").html(BPL.mobile);
		$("#Cookies").html(BPL.cookies);
		$("#GPU").html(BPL.getWebGLRenderer);
		$("#CPU").html(BPL.hwc);
		$("#Lang").html(BPL.lang);
		$("#Touch").html(BPL.getTouchCompatibility);
		$("#Plugins").html(BPL.plugin);
		$("#UA").html(BPL.ua);
		$("#fp1").html(BPL.fp1);
		$("#fp2").html(BPL.fp2);
		$("#fp3").html(BPL.fp3);
		$("#fp4").html(BPL.fp4);

		$("#priBPL").html(JSON.stringify(BPL, null, 4));
	</script>

	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>