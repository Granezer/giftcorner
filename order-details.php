<?php
require_once("config.php");

$page_title = "order-history";
$_SESSION["redirect"] = "order-history";

$reference_no  = isset($_GET["reference_no"]) ? $_GET["reference_no"] : 0;

if (empty($reference_no)) {
    header("Location: order-history");
    exit;
}

require_once("is-login.php");

$order = array();
try {
    $orderInstance = new Users\Orders();
    $order = $orderInstance->getOrders($user_id, $reference_no);
    $order = $order['data'];

    $bankInstance = new Settings\Banks();
    $banks = $bankInstance->getBanks();
} catch (Exception $e) {
    // echo $e->getMessage();exit;
    header("Location: order-history");
}
// echo json_encode($order); exit;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Order Details - <?php echo $site_title; ?></title>

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
                            <h2>Order Details</h2>
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
                                <form method="post" action="#">
                                    <?php 
                                    if (strtolower($order->status)=='awaiting payment') { ?>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <h3 class="text-danger">Bank Details
                                                <span style="font-size: 12px;"><br>Pay into the below account details. Make sure that the account name is <b>GIFTCORNER NG</b></span></h3>
                                            </div>
                                            <?php
                                            foreach ($banks['data'] as $key => $bank) {
                                                ?>
                                                <div class="col-md-6 text-warning">
                                                    Account Name: <?php echo $bank->acc_name;?><br>
                                                    Acctount Number: <?php echo $bank->acc_no;?><br>
                                                    Bank: <?php echo $bank->bank; ?><br><br>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="col-md-12" style="color: red">Kindly note that your order will not be confirmed/processed until we recieve your payment.</div>
                                        </div>
                                        <hr style="border: 1px solid #dfb802;">
                                        <br><br>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <h3>Shipping Details</h3>
                                            Name: <?php echo $order->first_name.' '.$order->last_name; ?>
                                            <br>
                                            Phone: <?php echo $order->phone; ?><br>
                                            Email: <?php echo $order->email; ?><br>
                                            Address: <?php echo $order->address; ?><br>
                                            City: <?php echo $order->city; ?><br>
                                            Country: <?php echo $order->country; ?><br><br>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Other Details</h3>
                                            Reference No: <?php echo $order->reference_no; ?><br>
                                            Sub Total Amount: <?php echo $order->sub_total; ?><br>
                                            Shipping Amount: <?php echo $order->shipping_amount; ?><br>
                                            Amount Paid: <?php echo $order->amount_paid; ?><br>
                                            Status: <?php if ($order->status=='Accepted') echo 'Confirmed'; else echo $order->status; ?><br><br>
                                        </div>
                                    </div>

                                    <br><br>
                                    <table cellspacing="0" class="shop_table cart">
                                        <thead>
                                            <tr>
                                                <th class="product-remove">&nbsp;</th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Qty</th>
                                                <th class="product-subtotal">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1; $total_amount = $order->sub_total;
                                            foreach ($order->cartDetails as $cart) {
                                                $images = explode("|", $cart->image_urls);
                                            ?>
                                                <tr class="cart_item">

                                                    <td class="product-thumbnail">
                                                        <a href="product-details?id=<?php echo $cart->id; ?>&name=<?php echo $cart->name; ?>&code=<?php echo md5($cart->name); ?>">
                                                            <!-- <img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="<?php echo $productImages.$images[0]; ?>"> -->

                                                            <?php
                                                            $file_ext = getFileExt($productImages.$images[0]);
                                                            if (!in_array($file_ext, $images_ext)) {
                                                                ?>
                                                                <video width="40" height="40" controls class="shop_thumbnail">
                                                                    <source src="<?php echo $productImages.$images[0]; ?>" type="video/<?php echo $file_ext; ?>">
                                                                    Your broser does not support this video
                                                                </video>
                                                            <?php
                                                            } else {
                                                                ?>
                                                                <img src="<?php echo $productImages.$images[0]; ?>" alt="<?php echo $cart->name; ?>"  width="145" height="145" class="shop_thumbnail">
                                                            <?php
                                                            }
                                                            ?>

                                                        </a>
                                                    </td>

                                                    <td class="product-name">
                                                        <a href="product-details?id=<?php echo $cart->id; ?>&name=<?php echo $cart->name; ?>&code=<?php echo md5($cart->name); ?>"><?php echo $cart->name; ?></a> 
                                                    </td>

                                                    <td class="product-price">
                                                        <span class="amount">N<?php echo $cart->amount; ?></span> 
                                                    </td>

                                                    <td><?php echo $cart->qty; ?></td>

                                                    <td class="product-subtotal">
                                                        <span class="amount">N<?php echo number_format(str_replace(',', '', $cart->amount) * $cart->qty); ?></span> 
                                                    </td>
                                                </tr>
                                            <?php
                                                $n++;
                                            }
                                            ?>  
                                            <tr>
                                                <td colspan="4" style="text-align: right;">Total Amount</td>
                                                <td><?php echo $total_amount; ?></td>
                                            </tr> 
                                        </tbody>
                                    </table>

                                    <?php
                                    if ($order->payment_history) {
                                    ?>
                                        <br>
                                        <table cellspacing="0" class="shop_table cart">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Reference No</th>
                                                    <th class="product-quantity">Date Paid</th>
                                                    <th class="product-price">Amount Paid</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $n = 1;
                                                $total_paid = 0;
                                                foreach ($order->payment_history as $payment) {
                                                    $amount = str_replace(",", '', $payment->amount_paid);
                                                    $total_paid += $amount;
                                                ?>
                                                    <tr class="cart_item">

                                                        <td>
                                                            <?php echo $payment->transaction_reference_no; ?>
                                                        </td>

                                                        <td><?php echo $payment->date_paid; ?></td>

                                                        <td>
                                                            <span class="amount">N<?php echo $payment->amount_paid; ?></span> 
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $n++;
                                                }
                                                ?>  
                                                <tr>
                                                    <td colspan="2" style="text-align: right;">Total Amount</td>
                                                    <td>N<?php echo number_format($total_paid); ?></td>
                                                </tr> 
                                            </tbody>
                                        </table>
                                    <?php
                                    }
                                    ?>   
                                </form>
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
    </body>
</html>