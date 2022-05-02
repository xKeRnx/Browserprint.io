<?php 
$__TOKEN = "hardcodeshitbykernstudios"; 
include('includes/config.php');

$activesite = 'privacy';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('include/head.php');?>

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="<?php echo $Web_URL; ?>assets/css/pages/privacy/privacy.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>
<body>
    

    <div id="headerWrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12 text-center">
				<a href="<?php echo $Web_URL; ?>"><h2 class="main-heading"><?php echo $_SERVERNAME; ?></a></h2></a>
                </div>
            </div>
        </div>
    </div>

    <div id="privacyWrapper" class="">
        <div class="privacy-container">
            <div class="privacyContent">

                <div class="d-flex justify-content-between privacy-head">
                    <div class="privacyHeader">
                        <h1>Terms of Service</h1>
                        <p>Updated Nov 22, 2020</p>
                    </div>
                </div>

                <div class="privacy-content-container">			

                </div>

            </div>
        </div>
    </div>

    <div id="miniFooterWrapper" class="">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="position-relative">
                        <div class="arrow text-center">
                            <p class="">Up</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 mx-auto col-lg-6 col-md-6 site-content-inner text-md-left text-center copyright align-self-center">
                            <?php echo $_FOOTTEXT; ?>
                        </div>
                        <div class="col-xl-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-right text-center align-self-center">
                           
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $Web_URL; ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $Web_URL; ?>bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $Web_URL; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script>
        // Scroll To Top
        $(document).on('click', '.arrow', function(event) {
          event.preventDefault();
          var body = $("html, body");
          body.stop().animate({scrollTop:0}, 500, 'swing');
        });
    </script>

</body>
</html>