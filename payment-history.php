<?php
require_once("config.php");

$page_title = "payment-history";

require_once("is-login.php");
$paymentInstance = new Payments();
$payments = $paymentInstance->getPayments(null, null, null, null, $user_id);
$payments = $payments['data'];
// echo json_encode($payments); exit;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Payment History - <?php echo $site_title; ?></title>

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
                            <h2>Payment History</h2>
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
                                    if ($payments) {
                                        ?>
                                        <table cellspacing="0" class="shop_table cart">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Order No</th>
                                                    <th>Status</th>
                                                    <th>Method</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $n = 1;
                                                foreach ($payments as $payment) {
                                                ?>
                                                   <tr>
                                                        <td><?php echo $n; ?></td>
                                                        <td><?php echo $payment->reference_no; ?></td>
                                                        <td><?php echo $payment->status;?>
                                                        </td>
                                                        <td><?php echo $payment->payment_mode; ?></td>
                                                        <td>NGN <?php echo $payment->amount_paid; ?></td>
                                                        <td><?php echo $payment->date_time; ?></td>
                                                    </tr> 
                                                <?php
                                                    $n++;
                                                }
                                                ?> 
                                            </tbody>
                                        </table>  
                                    <?php 
                                    } else {
                                        echo '<h3>Payment history is empty</h3> Click <a href="order-history">here</a> to make payment';
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