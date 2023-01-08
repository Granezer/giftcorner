<?php
require_once("config.php");

require_once("check-login.php");

$page_title = "login";

if (empty($_SESSION["redirect"])) 
    $_SESSION["redirect"] = "products";

if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reset Password - <?php echo $site_title; ?></title>

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
                        <h2>Login</h2>
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


                                <p>Enter your registered email address and we'll send you reset code right away</p>
                                <span style="color: red" id="login-response"></span>

                                <input type="hidden" name="transaction_id" id="transaction_id">
                                <input type="hidden" name="url" id="url" value="<?php echo $_SESSION["redirect"]; ?>">
                                <p class="form-row form-row-first">
                                    <label for="password">New Password <span class="required">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" class="input-text" style="width: 100%;">
                                </p>
                                <p class="form-row form-row-first">
                                    <label for="confirm_password">Confirm Password <span class="required">*</span>
                                    </label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="input-text" style="width: 100%;">
                                </p>
                                <p class="form-row form-row-first">
                                    <label for="code">Reset Code <span class="required">*</span>
                                    </label>
                                    <input type="text" id="code" name="code" class="input-text" style="width: 100%;">
                                </p>
                                <div class="clear"></div>


                                <p class="form-row">
                                    <button type="button" class="add_to_cart_button" id="reset_password_submit">Reset Password</button>
                                </p>
                                <p class="lost_password">
                                    <a href="login">I know my password?</a> | <a href="sign-up">Sign Up</a>
                                </p>

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

    <script src="js/pages/password/reset-password.js?p=<?php echo rand();?>" type="text/javascript"></script>
  </body>
</html> 