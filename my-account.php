<?php
require_once("config.php");

$page_title = "my-account";
$_SESSION["redirect"] = "my-account";

require_once("is-login.php");

$shippingInstance = new Users\Shipping();
$shipping = $shippingInstance->getDefaultShippingAddress($user_id);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>My Account - <?php echo $site_title; ?></title>

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
                            <h2>Dashboard</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>  --><!-- End Page title area -->
        
        
        <div class="single-product-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <?php require_once 'side-links.php'; ?>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="product-content-right">
                            <div class="woocommerce" style="font-size: 16px">
                                
                                <h3 class="title">My Dashboard</h3>
                                <p class="fw-medium tt-up">Hello, <?php echo $_SESSION['fullname'];?> (not <?php echo $_SESSION['fullname'];?>? <a href="logout">Sign out</a>)</p>
                                <p>From your account dashboard you can view your recent orders, manage your shipping addresses and <a href="profile">edit your password and account details.</a> </p>
                                
                                <div style="min-height: 10px"></div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="font-weight: bold; font-size: 18">My Profile</p>
                                        <ul style="list-style: none; margin: 0; padding: 0; font-size: 16px; line-height: 25px;">
                                            <li><?php echo $_SESSION['fullname'];?></li>
                                            <li><?php echo $_SESSION['phone'];?></li>
                                            <li><?php echo $_SESSION['email'];?></li>
                                        </ul>
                                        <br>
                                        <a href="profile" style="font-weight: bold;">Edit Profile</a>
                                    </div>

                                    <div class="col-md-6">
                                        <p style="font-weight: bold; font-size: 18">Current Shipping Address</p>
                                        <?php
                                        if ($shipping) {
                                        ?>
                                            <ul style="list-style: none; margin: 0; padding: 0; font-size: 16px; line-height: 25px;">
                                                <li><?php echo $shipping->first_name." ".$shipping->last_name;?></li>
                                                <li><?php echo $shipping->address;?></li>
                                                <li><?php echo $shipping->city;?></li>
                                                <li><?php echo $shipping->country;?></li>
                                            </ul>
                                            <br>
                                            <a href="edit-shipping-address?id=<?php echo $shipping->id;?>" style="font-weight: bold;">Edit Shipping Address</a>

                                        <?php
                                        } else {
                                        ?>  
                                            <span style="color: red">No Shipping Address Found</span>
                                            <br><br>
                                            <a href="new-shipping-address" style="font-weight: bold;">New Shipping Address</a>

                                        <?php
                                        }
                                        ?>
                                            
                                    </div>
                                </div>

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