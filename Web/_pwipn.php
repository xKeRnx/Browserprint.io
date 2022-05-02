<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/includes/pw/paymentwall.php');
require($_SERVER["DOCUMENT_ROOT"].'/includes/config.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/includes/log.php');

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

Paymentwall_Base::setApiType(Paymentwall_Base::API_VC);
Paymentwall_Base::setAppKey('');
Paymentwall_Base::setSecretKey('');


$pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);
if ($pingback->validate()) {
	$userId = $pingback->getUserId();
    $productId = 0;

	$virtualCurrency = isset($_GET['currency']) ? $_GET['currency'] : null;
	$refId = isset($_GET['ref']) ? $_GET['ref'] : null;
	
    $sql = "SELECT subscription_until FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if user exists
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $subscription_until);
                if (mysqli_stmt_fetch($stmt)) {
					if ($pingback->isDeliverable()) {
						if($subscription_until < date("Y-m-d H:i:s")){
							$subscription_until = date("Y-m-d H:i:s", strtotime("+ 1 month"));
						}else{
							$time = strtotime($subscription_until);
							$subscription_until = date("Y-m-d H:i:s", strtotime("+1 month", $time));
						}
						// deliver the product
						$sql_update = "UPDATE users SET currency = currency + ? WHERE id = ?";
						$stmt_update = mysqli_prepare($link, $sql_update);
						mysqli_stmt_bind_param($stmt_update, "ii", $virtualCurrency, $userId);
						mysqli_stmt_execute($stmt_update);
						mysqli_stmt_close($stmt_update);
						
						log_buy($userId, $productId, $virtualCurrency, "DELIVERED", $refId);
						
					} else if ($pingback->isCancelable()) {
						// withdraw the product
						$sql_update = "UPDATE users SET currency = currency + ? WHERE id = ?";
						$stmt_update = mysqli_prepare($link, $sql_update);
						mysqli_stmt_bind_param($stmt_update, "ii", $virtualCurrency, $userId);
						mysqli_stmt_execute($stmt_update);
						mysqli_stmt_close($stmt_update);
						
						log_buy($userId, $productId, $virtualCurrency, "Withdraw", $refId);
						
					} else if ($pingback->isUnderReview()) {
						// set "pending" as order status
						log_buy($userId, $productId, $virtualCurrency, "Pending", $refId);
					}
					echo 'OK'; // Paymentwall expects response to be OK, otherwise the pingback will be resent
				}
			}else{
				log_buy($userId, $productId, $virtualCurrency, "USERNOTFOUND", $refId);
				echo 'USERNOTFOUND';
			}
		}
	}
} else {
    echo $pingback->getErrorSummary();
}
?>