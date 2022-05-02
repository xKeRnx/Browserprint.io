<?php

// Log all POSTS, If error appears die error
function log_login($msg)
{
    // Prepare an insert statement
    $sql_ins = "INSERT INTO log (email, hwid1, hwid2, hwid3, hwid4, hwid5, server_ip, success, msg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt_ins = mysqli_prepare($GLOBALS["link"], $sql_ins)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_ins, "sssssssis", $param_username, $parm_hwid1, $parm_hwid2, $parm_hwid3, $parm_hwid4, $parm_hwid5, $parm_server_ip, $parm_success, $parm_msg);

        // Set parameters
        $param_username = $GLOBALS["post_username"];
        $parm_hwid1 = $GLOBALS["post_hwid1"];
        $parm_hwid2 = $GLOBALS["post_hwid2"];
        $parm_hwid3 = $GLOBALS["post_hwid3"];
        $parm_hwid4 = $GLOBALS["post_hwid4"];
        $parm_hwid5 = $GLOBALS["post_hwid5"];
        $parm_server_ip = $GLOBALS["post_server_ip"];
        $parm_success = $GLOBALS["auth"];
		$parm_msg = $msg;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_ins)) {
            //ALLOK
        } else {
            die($GLOBALS["errmsg"]);
        }
    } else {
        die($GLOBALS["errmsg"]);
    }
}

// Log all failed HeartBeats
function log_heartbeat_failed($e_Type)
{
    // Prepare an insert statement
    $sql_ins = "INSERT INTO hb_log (username, post_ban, server_ip, e_type) VALUES (?, ?, ?, ?)";
    if ($stmt_ins = mysqli_prepare($GLOBALS["link"], $sql_ins)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_ins, "ssss", $param_username, $parm_ban, $parm_server_ip, $e_Type);

        // Set parameters
        $param_username = $GLOBALS["post_username"];
        $parm_ban = $GLOBALS["post_ban"];
        $parm_server_ip = $GLOBALS["post_server_ip"];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_ins)) {
            //ALLOK
        } else {
            die($GLOBALS["errmsg"]);
        }
    } else {
        die($GLOBALS["errmsg"]);
    }
}

// Log all Purchases
function log_buy($user_id, $productId, $virtualCurrency, $status, $refId)
{
    // Prepare an insert statement
    $sql_ins = "INSERT INTO buy_log (user_id, productId, virtualCurrency, status, refId) VALUES (?, ?, ?, ?, ?)";
    if ($stmt_ins = mysqli_prepare($GLOBALS["link"], $sql_ins)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_ins, "sssss", $parm_user_id, $parm_productId, $parm_virtualCurrency, $parm_status, $parm_refId);

        // Set parameters
        $parm_user_id = $user_id;
        $parm_productId = $productId;
        $parm_virtualCurrency = $virtualCurrency;
		$parm_status = $status;
		$parm_refId = $refId;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_ins)) {
            //ALLOK
        } else {
            die($GLOBALS["errmsg"]);
        }
    } else {
        die($GLOBALS["errmsg"]);
    }
}