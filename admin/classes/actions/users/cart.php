<?php   
require_once 'require_files.php';

try {
    //assign value to variables
    $user_id = isset($_POST['user_id']) 
        ? $reg_activity->formatInput($_POST['user_id']) : '';
    $user_ses_id = isset($_POST['user_ses_id']) 
        ? $reg_activity->formatInput($_POST['user_ses_id']) : '';
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : '';
    $device_id = isset($_POST['device_id']) 
        ? $reg_activity->formatInput($_POST['device_id']) : null;

    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
    $qty = isset($_POST['qty']) ? $_POST['qty'] : 0;
    $item_size = isset($_POST['item_size']) 
        ? $reg_activity->formatInput($_POST['item_size']) : null;
    $color = isset($_POST['color']) 
        ? $reg_activity->formatInput($_POST['color']) : null;
    $type = isset($_POST['type']) 
        ? ucfirst($reg_activity->formatInput($_POST['type'])) : null;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType($type . " Cart");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");      

    if ($type != 'Retrieved') {
        if (empty($product_id))
            throw new Exception("Product Id is empty. Please try and rectify"); 
    }
    if ($type != 'Deleted' and $type != 'Retrieved' and $type != 'Moved' and $type != 'Removed') {
        if (empty($qty)) {
            throw new Exception("Quantity is empty. Please try and rectify");
        }
    }
    if (empty($transaction_id)){
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    if ($user_id) {
        if (empty($user_ses_id))
            throw new Exception("Some important values are empty. Please try and rectify");
    } else {
        if (empty($device_id))
            throw new Exception("No device ID found");
        $user_ses_id = $device_id;
        $reg_activity->setState($web);
    }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    //check if request is from web version
    if ($user_id) { 
        //Checks if the User exist as well as if the user is ban
        $reg_activity->validateUser();

        //Check if Session ID provided Matches with User ID
        $reg_activity->checkUser();
    }

    $cart = new Users\Carts();
    $wishlist = new Users\Wishlists();
    $report_id = 0;
    $message = '';
    
    switch ($type) {
        case 'Retrieved':
            $report_id = 0;
            break;
        case 'Add':
            $report_id = $cart->addToCart($user_id, $user_ses_id, $product_id, $qty, $color, $item_size);
            $message = 'Item added to cart';
            break;
        case 'Update':
            $count = 0;
            // $ids = explode("|", $product_id);
            // $qtys = explode("|", $qty);
            $ids = $product_id;
            $qtys = $qty;
            $item_sizes = isset($item_size) ?  $item_size : array();
            $colors = isset($color) ? $color : array();
            if (count($ids) != count($qtys)) 
                throw new Exception("Error: check products IDs");
            
            foreach ($ids as $product_id) {
                if ($product_id) {
                    $qty = $qtys[$count];
                    $item_size = isset($item_sizes[$count]) ? $item_sizes[$count] : null;
                    $color = isset($colors[$count]) ? $colors[$count] : null;
                    $report_id = $cart->editCart($user_id, $user_ses_id, $product_id, 
                        $qty, $color, $item_size);
                }
                $count++;
            }
            $message = 'Item updated';
            break;
        case 'Deleted':
            $report_id = $cart->deleteCart($user_ses_id, $product_id);
            $message = 'Item removed from cart';
            break;
        case 'Moved':
            if (empty($user_id)) {
                $wishlist->saveWishlistForUnknownUser($user_ses_id, $product_id);
            } else {
                $wishlist->saveWishlist($user_id, $product_id);
            }
            $report_id = $cart->deleteCart($user_ses_id, $product_id);
            $message = 'Item moved to wishlist';
            break;
        case 'Removed':
            if (empty($user_id)) {
                $wishlist->saveWishlistForUnknownUser($user_ses_id, $product_id);
            } else {
                $wishlist->saveWishlist($user_id, $product_id);
            }
            $report_id = $cart->addToCart($user_id, $user_ses_id, $product_id, 1, null);
            $message = 'Item moved to cart';
            break;
        default:
            throw new Exception("Invalid type");
            break;
    }

    if ($type == 'Retrieved') $message = "success";

    $result = $cart->getCartItemsBySession($user_id, $user_ses_id, 1);

    $sub_total = 0;
    $count = 0;
    foreach ($result as $value) {
        $sub_total += $value->total_amount;
        $count = $count + $value->qty;
    }

    $details = array(); 
    $details['total_amount'] = number_format($sub_total);
    $details['sub_total'] = number_format($sub_total);
    $details['shipping_amount'] = number_format(0);
    $details['total_cart_items'] = $count;

    $reg_activity->setReportTypeId($report_id);
    $reg_activity->createSuccessReport();

    echo json_encode(array('data' => $result, 'details' => $details, "success" => true, "message" => $message), JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}