<?php
require_once("config.php");

require_once("check-login.php");

$page_title = "sign-up";

if (empty($_SESSION["redirect"])) 
    $_SESSION["redirect"] = "products";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sign Up - <?php echo $site_title; ?></title>

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
                        <h2>Sign Up</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">

                            <form id="login-form-wrap" enctype="multipart/form-data">


                                <p>Please Enter Your Profile Details</p>
                                <span style="color: red" id="response"></span>

                                <input type="hidden" name="transaction_id" id="transaction_id">
                                <input type="hidden" name="url" id="url" value="<?php echo $_SESSION["redirect"]; ?>">
                                <p class="form-row form-row-first">
                                    <label for="fullname">Fullname <span class="required">*</span>
                                    </label>
                                    <input type="text" id="fullname" name="fullname" class="input-text" style="width: 100%;">
                                </p>
                                <p class="form-row form-row-first">
                                    <label for="phone">Phone <span class="required">*</span>
                                    </label>
                                    <input type="text" id="phone" name="phone" class="input-text" style="width: 100%;">
                                </p>
                                    <label for="email">Email <span class="required">*</span>
                                    </label>
                                    <input type="text" id="email" name="email" class="input-text" style="width: 100%;">
                                </p>
                                <p class="form-row form-row-last">
                                    <label for="password">Password <span class="required">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" class="input-text" style="width: 100%;">
                                </p>
                                <p class="form-row form-row-last">
                                    <label for="password2">Confirm Password <span class="required">*</span>
                                    </label>
                                    <input type="password" id="password2" name="password2" class="input-text" style="width: 100%;">
                                </p>
                                <div class="clear"></div>


                                <p class="form-row">
                                    <button type="button" class="add_to_cart_button" id="sign_up_submit">Sign Up</button>
                                </p>
                                <p class="lost_password">Already have account?
                                    <a href="login">Login</a>
                                </p>
                                <input type="hidden" name="device_id" class="device_id">
                                            <input type="hidden" name="device_name" class="device_name">

                                <div class="clear"></div>
                            </form>
                        </div>                       
                    </div>                    
                </div>
                
                <div class="col-md-4">
                    <?php require_once 'side-products.php'; ?>
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

    <script src="js/pages/user/sign-up.js?p=<?php echo rand();?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(".device_id").val(getCookie("device_id"));
        $(".device_name").val(getCookie("device_name"));
    </script>
  </body>
</html> 