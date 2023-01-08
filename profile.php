<?php
require_once("config.php");

$page_title = "profile";
$_SESSION["redirect"] = "profile";

require_once("is-login.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>My Profile - <?php echo $site_title; ?></title>

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
                            <h2>My Profile</h2>
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
                                <div id="customer_details" class="col2-set">
                                    <form enctype="multipart/form-data" action="#" class="checkout" method="post" name="checkout">
                                        <div class="col-1">
                                            <div class="woocommerce-billing-fields">
                                                <h3>Profile Info</h3>
                                                <h5 id="response" style="color: red; font-weight: bold;"></h5>
                                                <input type="hidden" class="transaction_id" name="transaction_id">
                                                <p class="form-row form-row-first validate-required">
                                                    <label class="" for="fullname">Fullname <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" placeholder="" id="fullname" name="fullname" class="input-text" value="<?php echo $_SESSION['fullname'];?>">
                                                </p>

                                                <p class="form-row form-row-last validate-required">
                                                    <label class="" for="gender">Gender <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <select id="gender" name="gender" class="input-text ">
                                                        <option value="male">Male</option>
                                                        <option <?php if ($_SESSION['gender']=="female") echo "selected";?> value="female">Female</option>
                                                    </select>
                                                </p>

                                                <div class="clear"></div>

                                                <p class="form-row form-row-first validate-required validate-email">
                                                    <label class="" for="email">Email Address <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input readonly type="text" placeholder="" id="email" name="email" class="input-text " value="<?php echo $_SESSION['email'];?>">
                                                </p>

                                                <p class="form-row form-row-last validate-required validate-phone">
                                                    <label class="" for="phone">Phone <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" placeholder="" id="phone" name="phone" class="input-text " value="<?php echo $_SESSION['phone'];?>">
                                                </p>

                                                <button type="button" class="add_to_cart_button" id="update_profile_submit">Update Profile</button>

                                            </div>
                                        </div>
                                    </form>
                                    <form enctype="multipart/form-data" action="#" class="checkout" method="post" name="checkout">
                                        <div class="col-2">
                                            <div class="woocommerce-billing-fields">
                                                <h3>Change Password</h3>
                                                <h5 id="response2" style="color: red; font-weight: bold;"></h5>
                                                <input type="hidden" class="transaction_id" name="transaction_id">
                                                <p class="form-row form-row-last validate-required validate-old-password">
                                                    <label class="" for="current_password">Current Password <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="Password" id="current_password" name="current_password" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-last validate-required validate-new-password">
                                                    <label class="" for="new_password">New Password <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="Password" id="new_password" name="new_password" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-last validate-required validate-new-password2">
                                                    <label class="" for="new_password2">Confirm Password <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="Password" id="new_password2" name="new_password2" class="input-text ">
                                                </p>

                                                <button type="button" class="add_to_cart_button" id="change_password_submit">Change Password</button>

                                            </div>

                                        </div>
                                    </form>

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

        <script src="js/pages/user/profile.js?p=<?php echo rand();?>" type="text/javascript"></script>
        <script src="js/pages/password/change-password.js?p=<?php echo rand();?>" type="text/javascript"></script>
    </body>
</html>