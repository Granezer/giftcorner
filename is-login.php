<?php

// remove later
// $_SESSION['user_id'] = 1;
// $_SESSION['user_ses_id'] = 'iueiekjekjkjee';
// session_destroy();

if(!isset($_SESSION['user_id']) and !isset($_SESSION['user_ses_id']) ) {
    $_SESSION['error'] = "Access denied! You must login properly";
    header("Location: ".$url_endpoint."login"); 
    exit;
}

$user_id = $_SESSION['user_id'];
$shippingInstance = new Users\Shipping();