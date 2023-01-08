<?php
require_once("config.php");

$page_title = "shipping-addresses";
$_SESSION["redirect"] = "shipping-addresses";

require_once("is-login.php"); 

$shippings = $shippingInstance->getShippingAddresses($user_id);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Shipping Addresses - <?php echo $site_title; ?></title>

        <meta name="robots" content="noindex, follow" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php require_once 'css-header.php'; ?>
    </head>
    <body>
   
        <!-- Header Area -->
        <?php require_once 'header.php'; ?>
        <!-- End header area -->
        
        <!-- <div class="product-big-title-area" style="background: #CCC">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>Shipping Addresses</h2>
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
                        <h5 id="response" style="color: red; font-weight: bold;"></h5>
                        <div><a href="new-shipping-address" class="add_to_cart_button"><i class="fa fa-plus"></i> New Shipping Address</a></div>
                        <h5>&nbsp;</h5>
                        <?php
                        if($shippings) {
                        ?>
                           <h5 style="color: red; font-weight: bold;">The first address is your default shipping address. Kindly change it by clicking on the plus(+) sign</h5> 
                        <?php
                        }
                        ?>
                        <div class="product-content-right">
                            <div class="woocommerce">
                                <form method="post" action="#">
                                    <table cellspacing="0" class="shop_table cart">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Fullname</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Date</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            foreach ($shippings as $shipping) {
                                            ?>
                                                <tr class="cart_item" <?php if ($n==1) echo 'style="color: green; font-weight: bold;"';?>>
                                                    <td><?php echo $n; ?></td>

                                                    <td><?php echo $shipping->first_name.' '.$shipping->last_name;?></td>

                                                    <td><?php echo $shipping->phone;?></td>

                                                    <td><?php echo $shipping->email;?></td>

                                                    <td><?php echo $shipping->address;?></td>

                                                    <td><?php echo formatDate($shipping->date_time);?></td>

                                                    <td>
                                                        <?php
                                                        if ($shipping->status != 1) {
                                                        ?>
                                                            <a title="Set as default shipping address" href="#" onclick="return setDefaultAddress(<?php echo $shipping->id;?>);"><i class="fa fa-plus"></i> </a> 
                                                            &nbsp;&nbsp;&nbsp;
                                                        <?php
                                                        }
                                                        ?>
                                                        <a title="Edit shipping address" href="edit-shipping-address?id=<?php echo $shipping->id;?>"><i class="fa fa-pencil"></i> </a> 
                                                        <a title="Delete shipping address" href="#" onclick="return deleteShippingAddress(<?php echo $shipping->id;?>);"><i class="fa fa-trash"></i> </a> 
                                                    </td>
                                                </tr>
                                            <?php
                                             $n++;
                                            }
                                            ?> 
                                        </tbody>
                                    </table>
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

        <script src="js/pages/shipping/index.js?p=<?php echo rand();?>" type="text/javascript"></script>

    </body>
</html>