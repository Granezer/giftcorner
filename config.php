<?php
session_start();

require_once 'constants.php';
require_once 'auto-load.php';

date_default_timezone_set($_SERVER['TIME_ZONE']);

$url_endpoint = $_SERVER['BASIC_URL'];
$site_title = $_SERVER['COM_TITLE'];
$page_title = '';
$page_name = '';
$sql = '';
$productImages = $url_endpoint . "admin/assets/media/products/";
$remove_cache = rand(1234567, 9999999); 

$images_ext = array('jpg','jpeg','png','gif');

// check login
$is_login = true;
if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_ses_id'])) {
    $is_login = false;
    setcookie("user_id", null, -1, '/');
    setcookie("user_ses_id", null, -1, '/');
}

if (isset($_SESSION["url"])) {
    $redirect_user = $_SESSION["url"];
    unset($_SESSION["url"]);
    header("Location: $redirect_user");
    exit;
} else {

    $redirectUserToThisUrl = after('/', $_SERVER['REQUEST_URI']);
    $_SESSION["return_url"] = $redirectUserToThisUrl;
    $original_url = $redirectUserToThisUrl;
    $link = explode("/", $redirectUserToThisUrl);
    if (in_array("admin", $link)) {
        $redirectUserToThisUrl = after('/', $redirectUserToThisUrl);
    }

    if (isset($_SESSION['success'])) {
        $sql = $_SESSION['success'];
    } elseif (isset($_SESSION['error'])) {
        $sql = $_SESSION['error'];
    } 
    unset($_SESSION['success']);
    unset($_SESSION['error']);
}

$reporting = null;
$productInstance = new Products();

if (!isset($_COOKIE['device_id']) && !isset($_SESSION["device_id"])) { 
    $time = time() + (10 * 365 * 24 * 60 * 60);
    $libraryInstance = new Library();
    $device = $libraryInstance->generateDeviceIdAndName(); 
    $_SESSION["device_id"] = $device['device_id'];
    $_SESSION["device_name"] = $device['device_name'];  
    setcookie("device_id", $device['device_id'], $time, '/');
    setcookie("device_name", $device['device_name'], $time, '/');
}

if (!isset($_SESSION["device_id"])) { 
    $_SESSION["device_id"] = $_COOKIE['device_id'];
    $_SESSION["device_name"] = $_COOKIE['device_name'];  
}

function after ($character, $url) {
    $url = ltrim($url, '/');
    if (!is_bool(strpos($url, $character)))
    return substr($url, strpos($url,$character)+strlen($character));
}

function formatDate ($date) {
    return date("l jS M, Y. g:iA", strtotime($date));
}

function formatDateOrTime ($date_or_time, $date = true) {
    if($date) return date("l jS M, Y", strtotime($date_or_time));

    return date("H:i", strtotime($date_or_time));
}

function dateConvertion($date) {
    $formatInput = 'Y-m-d'; //Give any format here, this would be converted into your format

    $formatOut = 'd/m/Y'; // Your format
    return DateTime::createFromFormat($formatInput, $date)->format($formatOut);
}

function getColor($no) {
    $value = '';
    if ($no >= 80) {
        $value = "success";
    } elseif ($no >= 70 && $no < 80) {
        $value = "purple";
    } elseif ($no >= 50 && $no < 70) {
        $value = "info";
    } elseif ($no >= 40 && $no < 50) {
        $value = "primary";
    } elseif ($no >= 30 && $no < 40) {
        $value = "warning";
    } elseif ($no >= 20 && $no < 30) {
        $value = "danger";
    } else {
        $value = "secondary";
    }

    return $value;
}

function checkUrl($url) {
    if (empty($url)) {
        return false;
    }

    if (strpos($url, "http://") === 0 || strpos($url, "https://") === 0) {
        $array = get_headers($url);
        $string = $array[0];
        if (strpos($string, "200")) {
            return true;
        } else {
            return false;
        }
    } else return false;
}

function getFileExt($file){
    $ext = pathinfo(
        parse_url($file, PHP_URL_PATH), 
        PATHINFO_EXTENSION
    );

    return $ext;
}