<?php 
$__TOKEN = "hardcodeshitbykernstudios"; 
include('includes/config.php');

$activesite = '403';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('include/head.php');?>
    <link href="<?php echo $Web_URL; ?>assets/css/pages/error/style-400.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
</head>
<body class="error404 text-center">
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
                <br>
            </div>
        </div>
    </div>
    <div class="container-fluid error-content">
        <div class="">
            <h1 class="error-number">403</h1>
            <p class="mini-text">Access is denied!</p>
            <p class="error-text mb-4 mt-1">You do not have permission to view this directory or page using the credentials that you supplied.</p>
            <a href="<?php echo $Web_URL; ?>" class="btn btn-primary mt-5">Go Back</a>
        </div>
    </div>    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $Web_URL; ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $Web_URL; ?>bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $Web_URL; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>