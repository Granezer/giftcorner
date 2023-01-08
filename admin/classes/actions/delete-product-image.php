<?php
session_start();

require_once "../Database.php";
 
$target_dir = "../../assets/media/products/";
$image_id = isset($_SESSION['user_ses_id']) ? $_SESSION['user_ses_id'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;

$name = $image_id.'-'.$name;

$databaseInstance = new Database();
$query = "DELETE FROM product_images WHERE image_id = ? AND name = ?";
$databaseInstance->deleteRow($query, array($image_id, $name));

unlink($target_dir.$name);
echo $status = 1;