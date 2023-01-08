<?php
require_once("config.php");

$page_title = "order-history";
$_SESSION["redirect"] = "order-history";

require_once("is-login.php");
$orderInstance = new Users\Orders();
$orders = $orderInstance->getOrders($user_id);
// $orders = $orders['data'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Order History - <?php echo $site_title; ?></title>

        <meta name="robots" content="noindex, follow" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <?php require_once 'css-header.php'; ?>
      </head>
      <body>
   
        <!-- Header Area -->
        <?php require_once 'header.php'; ?>
        <!-- End header area -->
        
        <!-- <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>Order History</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> --> <!-- End Page title area -->
        
        
        <div class="single-product-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <?php require_once 'side-links.php'; ?>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="product-content-right">
                            <div class="woocommerce">
                                <!-- <form method="post" action="#"> -->
                                    <span id="paystack_response" style="color: red;"></span>
                                    <table cellspacing="0" class="shop_table cart">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Order#</th>
                                                <th>Status</th>
                                                <th>Shipping Address</th>
                                                <th class="product-subtotal">Total</th>
                                                <th>Date Time</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            foreach ($orders as $order) {
                                            ?>
                                               <tr class="cart_item">
                                                    <td><?php echo $n; ?></td>

                                                    <td><?php echo $order->reference_no; ?></td>

                                                    <td><?php if ($order->status =='Accepted') echo 'Confirmed'; else echo $order->status; ?></td>

                                                    <td><?php echo $order->address; ?></td>

                                                    <td><?php echo $order->total_amount; ?></td>

                                                    <td><?php echo $order->date_time; ?></td>

                                                    <td>
                                                        <a title="View Items" href="order-details?id=<?php echo $order->id; ?>&reference_no=<?php echo $order->reference_no; ?>&code=<?php echo md5($order->reference_no); ?>"><i class="fa fa-eye"></i> </a> 
                                                        <?php 
                                                        if ($order->status == "Awaiting Payment") {
                                                            $total_amount = str_replace(',', '', $order->total_amount);
                                                        ?>
                                                            <hr>
                                                            <!-- <a title="View Items" href="make-payment?id=<?php echo $order->id; ?>&reference_no=<?php echo $order->reference_no; ?>&code=<?php echo md5($order->reference_no); ?>">Pay Now </a> -->

                                                            <!-- <button type="button" onclick="return showPaymentDialog(<?php echo $order->reference_no.","."'".$total_amount."'".","."'".$order->total_amount."'"; ?>);" class="add_to_cart_button">Pay Now</button> -->
                                                            <a title="View Items" href="order-details?id=<?php echo $order->id; ?>&reference_no=<?php echo $order->reference_no; ?>&code=<?php echo md5($order->reference_no); ?>" class="text-danger">Pay Now </a> 
                                                        <?php
                                                        }
                                                        ?>     
                                                    </td>
                                                </tr> 
                                            <?php
                                                $n++;
                                            }
                                            ?>   
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="registered_name" value="<?php if(isset($_SESSION['fullname'])) echo $_SESSION['fullname']; ?>">
                                    <input type="hidden" id="registered_email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
                                    <input type="hidden" id="registered_phone" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>">
                                    <input type="hidden" id="order_no">
                                    <input type="hidden" id="amount_to_pay">
                                    <button type="submit" id="pay_with_paystack_submit" class="btn btn-sqr" style="display: none;">pay with paystack</button>
                                <!-- </form> -->
                            </div>                        
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Area -->
        <?php require_once 'footer.php'; ?>
        <!-- End Footer area -->

        <!-- Js Area -->
        <?php require_once 'footer-js.php'; ?>
        <!-- End Js area -->
        <script src="js/pages/order/payment.js?p=1" type="text/javascript"></script>
    </body>
</html>