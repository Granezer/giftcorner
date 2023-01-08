<?php
require_once 'require_files.php';
    
try {
    //assign value to variables
    $shipping_id = isset($_GET['shipping_id']) 
        ? $reg_activity->formatInput($_GET['shipping_id']) : 0;
    $state = isset($_GET['state']) 
        ? $reg_activity->formatInput($_GET['state']) : 0;
    $country = isset($_GET['country']) 
        ? $reg_activity->formatInput($_GET['country']) : 0;
    $weight = isset($_GET['weight']) 
        ? $reg_activity->formatInput($_GET['weight']) : 2;
    
    $get_request = json_encode($_GET); 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");

    if (empty($shipping_id) && empty($state) && empty($country))
        throw new Exception("No shipping info found");     

    $free_states = array("lagos", "fct", "benue");
    $shippingCost = new Settings\States();
    
    if (!empty($shipping_id)) {
        $shipping = new Users\Shipping();
        $response = $shipping->getShippingAddress($shipping_id);

        if (empty($response))
            throw new Exception("No shipping address found"); 

        $country = $response->country;

        $response = $shippingCost->getState($response->state_id);
        if ($response['data']) $state = $response['data']->name;
    }    

    if (!empty($state) and !in_array(strtolower($state), $free_states)) {
        $response = $shippingCost->getStatePriceByWeight($state, $weight);

    } elseif ($country and strtolower($country) != "nigeria") {
        $shippingCost = new Settings\Country();
        $response = $shippingCost->getCountryPriceByWeight($country, $weight);

    } elseif(in_array(strtolower($state), $free_states)) {
        $response = new stdClass();
        $response->state = $state;
        $response->country = $country;
        $response->price = 0;
        $response->amount = number_format(0);
        $response->weight = $weight;
    } else throw new Exception("No shipping address found");

    $response = array(
        "data" => $response,
        "message"=>"success",
        "success"=>true
    );
    
    echo json_encode($response, JSON_PRETTY_PRINT);  //return feedback
    
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}