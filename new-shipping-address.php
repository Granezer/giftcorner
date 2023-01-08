<?php
require_once("config.php");

$page_title = "shipping-addresses";
$_SESSION["redirect"] = "new-shipping-address";

require_once("is-login.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>New Shipping Address - <?php echo $site_title; ?></title>

        <meta name="robots" content="noindex, follow" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <?php require_once 'css-header.php'; ?>
    </head>
    <body>
   
        <!-- Header Area -->
        <?php require_once 'header.php'; ?>
        <!-- End header area -->
        
        <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>New Shipping Address</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Page title area -->
        
        
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
                                <form enctype="multipart/form-data" class="checkout" name="checkout">

                                    <div id="customer_details" class="col2-set">
                                        <div class="col-1">
                                            <div class="woocommerce-billing-fields">
                                                <h3>New Shipping Address</h3>
                                                <h5 id="response" style="color: red; font-weight: bold;"></h5>

                                                <p class="form-row form-row-first validate-required">
                                                    <label class="" for="first_name">First Name <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="" id="first_name" name="first_name" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-last validate-required">
                                                    <label class="" for="last_name">Last Name <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="" id="last_name" name="last_name" class="input-text ">
                                                </p>
                                                <div class="clear"></div>

                                                <p class="form-row form-row-wide address-field validate-required">
                                                    <label class="" for="address">Address <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="Street address" id="address" name="address" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-first validate-required validate-email">
                                                    <label class="" for="email">Email Address <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="" id="email" name="email" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-last validate-required validate-phone">
                                                    <label class="" for="phone">Phone <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="" id="phone" name="phone" class="input-text ">
                                                </p>
                                                
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="woocommerce-billing-fields">
                                                <h3>&nbsp;</h3>
                                                <p class="form-row form-row-last address-field validate-required validate-postcode" data-o_class="form-row form-row-last address-field validate-required validate-postcode">
                                                    <label class="" for="postcode">Postcode <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="Postcode / Zip" id="postcode" name="postcode" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-wide address-field validate-required" data-o_class="form-row form-row-wide address-field validate-required">
                                                    <label class="" for="city">Town / City <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="Town / City" id="city" name="city" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
                                                    <label class="" for="state">State <abbr title="required" class="required">*</abbr></label>
                                                    <select class="country_to_state country_select" id="state" name="state">
                                                        </select>
                                                </p>

                                                <p class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                    <label class="" for="country">Country <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <select class="country_to_state country_select" id="country" name="country">
                                                    </select>
                                                </p>
                                                <div class="clear"></div>

                                                <p>
                                                    <input type="hidden" value="created" name="type">
                                                    <input type="hidden" name="transaction_id" class="transaction_id">
                                                    <label>&nbsp;</label>
                                                    <button type="button" id="new_shipping_address_submit" class="add_to_cart_button">Save Address</button>
                                                </p>

                                            </div>
                                        </div>

                                    </div>
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

        <script src="js/pages/general/get-states.js" type="text/javascript"></script>

        <script src="js/pages/general/get-countries.js" type="text/javascript"></script>
        <script src="js/pages/shipping/index.js?p=<?php echo rand();?>" type="text/javascript"></script>
    </body>
</html>