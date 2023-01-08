<?php
try {
	require_once __DIR__.'/../../auto-load.php';

	if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required"); 
	 
	$target_dir = "../../assets/media/products/";
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$index = isset($_POST['index']) ? $_POST['index'] : null;

	if (!$id || !$index) throw new Exception("Error Processing Request", 1);
	
	$productInstance = new Products();
	$response = $productInstance->getProduct($id);

	if (!$response['data']) throw new Exception("Product not found", 1);
	
	$images = explode("|", $response['data']->image_urls);
	$image_urls = '';
	$count = 0;
	foreach ($images as $image) {
		if (($index - 1) == $count) {
			unlink($target_dir.$image);
		} else $image_urls .= $image.'|';
		$count++;
	}

	$image_urls = rtrim($image_urls, '| ');
	$productInstance->updateProductImage($id, $image_urls);

	$response['data']->image_urls = $image_urls;
	echo json_encode($response);
	exit;

} catch (Exception $error) {
	echo json_encode(array("success"=>false, "message"=> $error->getMessage()));
}