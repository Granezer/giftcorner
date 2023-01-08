<?php
session_start();

require_once __DIR__.'/../../auto-load.php';

$target_dir = "../../assets/media/products/";
$product_id = isset($_SESSION['user_ses_id']) ? $_SESSION['user_ses_id'] : null;

if (!$product_id) {
	echo $status = 0;
	exit;
}

$library = new Library();
$filename = $library->generateCode(30);
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
// $name = $product_id.'-'.$_FILES['file']['name'];
$name = $product_id.'-'.$filename.'.'.$ext;

// $mime = mime_content_type($_FILES["file"]);
// if (strstr($mime, "video/")) {
//     // this code for video
// } else if(strstr($mime, "image/")) {
//     // this code for image
// }

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$name)) {

	$databaseInstance = new Database();
	$query = "INSERT INTO product_images SET name = ?, image_id = ?";
    $databaseInstance->insertRow($query, array($name, $product_id));
    echo $status = 1;
}