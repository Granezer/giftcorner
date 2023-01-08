<?php
require_once("config.php");

$page_title = "checkout";

$user_ses_id = isset($_SESSION['user_ses_id']) 
    ? $_SESSION['user_ses_id'] : $_COOKIE['device_id'];
$user_id = isset($_SESSION['user_id']) 
    ? $_SESSION['user_id'] : null;

$cartInstance = new Users\Carts();
$carts = $cartInstance->getCartItemsBySession($user_id, $user_ses_id, 1);
$total_amount = 0;

if (!$carts) {
    header("Location: index");
    exit();
}

$first_name = $last_name = $phone = $email = $address = $postcode = $city = $state = $country = $state_id = $country_id = $shipping_id = null;
$states = $countries = array();

$shippingInstance = new Users\Shipping();
$shipping = $shippingInstance->getDefaultShippingAddress($user_id, 1);
if ($shipping) {
    $first_name = $shipping->first_name;
    $last_name = $shipping->last_name;
    $phone = $shipping->phone;
    $email = $shipping->email;
    $address = $shipping->address;
    $postcode = $shipping->postcode;
    $city = $shipping->city;
    $state = $shipping->state;
    $country = $shipping->country;
    $state_id = $shipping->state_id;
    $country_id = $shipping->country_id;
    $shipping_id = $shipping->id;
} else {
    $stateInstance = new Settings\States();
    $states = $stateInstance->getStates();

    $countryInstance = new Settings\Country();
    $countries = $countryInstance->getCountries();
}
// echo json_encode($shipping); exit;

$shipping_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Checkout - <?php echo $site_title; ?></title>
    
        <meta name="robots" content="noindex, follow" />
        <meta property="og:type" content="product" />
        <meta property="og:site_name" content="<?php echo $site_title; ?>" />
        <meta property="og:title" content="Giftcorner NG |  Online Shopping for household items!" />
        <meta property="og:description" content="Giftcorner NG the #1 Shopping Mall in Nigeria - Shop Online for All Kinds of household items &amp; Enjoy Great Prices And Offers | Secure Payments - Fast Delivery - Free Returns" />
        <meta property="og:url" content="<?php echo $url_endpoint; ?>" />
        <meta property="og:image" content="<?php echo $url_endpoint; ?>img/gift-corner-ng-logo.jpg" />
        <meta property="og:locale" content="en_NG" />
        <meta name="title" content="Giftcorner NG |  Online Shopping for household items!" />
        <meta name="description" content="Giftcorner NG the #1 Shopping Mall in Nigeria - Shop Online for All Kinds of household items &amp; Enjoy Great Prices And Offers | Secure Payments - Fast Delivery - Free Returns" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php require_once 'css-header.php'; ?>
    </head>
    <body>
   
        <!-- Header Area -->
        <?php require_once 'header.php'; ?>
        <!-- End header area -->
        
       <!--  <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>Shopping Cart</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
        
        <div class="single-product-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    <!-- <div class="col-md-4">
                        <?php //require_once 'side-products.php'; ?>
                    </div> -->
                    
                    <div class="col-md-12">
                        <div class="product-content-right">
                            <div class="woocommerce">
                                <?php
                                if (!isset($user_id)) {
                                ?>
                                    <div class="woocommerce-info">Returning customer? <a class="showlogin" data-toggle="collapse" href="#login-form-wrap" aria-expanded="false" aria-controls="login-form-wrap">Click here to login</a>
                                    </div>

                                    <form id="login-form-wrap" class="login collapse" enctype="multipart/form-data">
                                        <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Shipping section.</p>
                                        <span style="color: red" id="login-response"></span>

                                        <input type="hidden" name="transaction_id" id="transaction_id2">
                                        <input type="hidden" name="url" id="url" value="<?php echo $_SESSION["redirect"]; ?>">

                                        <p class="form-row form-row-first">
                                            <label for="email">Email <span class="required">*</span>
                                            </label>
                                            <input type="text" id="email" name="email" class="input-text">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <label for="password">Password <span class="required">*</span>
                                            </label>
                                            <input type="password" id="password" name="password" class="input-text">
                                        </p>
                                        <div class="clear"></div>


                                        <p class="form-row">
                                            <button type="button" class="add_to_cart_button" id="login_submit">Login</button>
                                            <label class="inline" for="remember-me"><input type="checkbox" value="forever" id="remember-me" name="remember"> Remember me </label>
                                        </p>
                                        <p class="lost_password">
                                            <a href="#">Lost your password?</a>
                                        </p>
                                        <p>
                                                    <input type="hidden" name="device_id" class="device_id">
                                                    <input type="hidden" name="device_name" class="device_name">
                                                </p>

                                        <div class="clear"></div>
                                    </form>
                                <?php
                                }
                                ?>

                                <div class="woocommerce-info">Have a coupon? <a class="showcoupon" data-toggle="collapse" href="#coupon-collapse-wrap" aria-expanded="false" aria-controls="coupon-collapse-wrap">Click here to enter your code</a>
                                </div>

                                <form id="coupon-collapse-wrap" method="post" class="checkout_coupon collapse">

                                    <p class="form-row form-row-first">
                                        <input type="text" placeholder="Coupon code" value="" id="coupon_code" class="input-text" name="coupon_code">
                                    </p>

                                    <p class="form-row form-row-last">
                                        <button type="button" class="add_to_cart_button wc-forward" id="apply_coupon_submit">Apply Coupon</button>
                                    </p>

                                    <div class="clear"></div>
                                </form>

                                <form enctype="multipart/form-data" action="#" class="checkout" method="post" name="checkout">

                                    <div id="customer_details" class="col2-set">
                                        <div class="col-1">
                                            <div class="woocommerce-billing-fields">
                                                <h3>Shipping Details</h3>

                                                <p id="first_name_field" class="form-row form-row-first validate-required">
                                                    <input type="hidden" name="fullname" id="fullname">
                                                    <label class="" for="first_name">First Name <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="<?php echo $first_name;?>" placeholder="" id="first_name" name="first_name" class="input-text ">
                                                </p>

                                                <p id="last_name_field" class="form-row form-row-last validate-required">
                                                    <label class="" for="last_name">Last Name <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="<?php echo $last_name;?>" placeholder="" id="last_name" name="last_name" class="input-text ">
                                                </p>
                                                <div class="clear"></div>

                                                <p id="email_field" class="form-row form-row-first validate-required validate-email">
                                                    <label class="" for="email">Email Address <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="<?php echo $email;?>" placeholder="" id="email" name="email" class="input-text ">
                                                </p>

                                                <p id="phone_field" class="form-row form-row-last validate-required validate-phone">
                                                    <label class="" for="phone">Phone <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="<?php echo $phone;?>" placeholder="" id="phone" name="phone" class="input-text ">
                                                </p>
 
                                                <p id="order_comments_field" class="form-row notes">
                                                    <label class="" for="order_comments">Order Notes</label>
                                                    <textarea cols="5" rows="2" placeholder="Notes about your order, e.g. special notes for delivery." id="order_comments" class="input-text " name="order_comments"></textarea>
                                                </p>
                                                <p>
                                                    <input type="hidden" name="device_id" class="device_id">
                                                    <input type="hidden" name="device_name" class="device_name">
                                                </p>

                                                <?php
                                                if (!isset($user_id)) {
                                                ?>
                                                    <div class="create-account">
                                                        <p>Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                                                        <p id="password_field" class="form-row validate-required">
                                                            <label class="" for="password">Account password <abbr title="required" class="required">*</abbr>
                                                            </label>
                                                            <input type="password" value="" placeholder="Password" id="password" name="password" class="input-text">
                                                        </p>
                                                        <div class="clear"></div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="woocommerce-shipping-fields">
                                                <h3 id="ship-to-different-address">
                                                <label class="checkbox" for="ship-to-different-address-checkbox"></label>
                                                </h3>
                                                <div class="shipping_address" style="display: block;">

                                                    <p id="address_field" class="form-row form-row-wide address-field validate-required">
                                                    <label class="" for="address">Address <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="<?php echo $address;?>" placeholder="Street address" id="address" name="address" class="input-text ">
                                                    </p>
                                                    <p id="postcode_field" class="form-row form-row-last address-field validate-required validate-postcode" data-o_class="form-row form-row-last address-field validate-required validate-postcode">
                                                        <label class="" for="postcode">Postcode <abbr title="required" class="required">*</abbr>
                                                        </label>
                                                        <input type="text" value="<?php echo $postcode;?>" placeholder="Postcode / Zip" id="postcode" name="postcode" class="input-text ">
                                                    </p>

                                                    <p id="city_field" class="form-row form-row-wide address-field validate-required" data-o_class="form-row form-row-wide address-field validate-required">
                                                        <label class="" for="city">Town / City <abbr title="required" class="required">*</abbr>
                                                        </label>
                                                        <input type="text" value="<?php echo $city;?>" placeholder="Town / City" id="city" name="city" class="input-text ">
                                                    </p>

                                                    <p id="state_field" class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
                                                        <label class="" for="state">State</label>
                                                        <span id="state_id" style="display: none;"><?php echo $state_id;?></span>
                                                        <select class="country_to_state country_select" id="state" name="state">
                                                        </select>
                                                    </p>

                                                    <div class="clear"></div>
                                                    <p id="country_field" class="form-row form-row-wide address-field update_totals_on_change validate-required woocommerce-validated">
                                                        <label class="" for="country">Country <abbr title="required" class="required">*</abbr>
                                                        </label>
                                                        <span id="country_id" style="display: none;"><?php echo $country_id;?></span>
                                                        <select class="country_to_state country_select" id="country" name="country">
                                                        </select>
                                                    </p>
                                                    <div class="clear"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $shippings = 1;
                                    if (!$shipping) {
                                        $shippings = 0;
                                    ?>
                                        <!-- <h2><a class="shipping-calculator-button" data-toggle="collapse" href="#calcalute-shipping-wrap" aria-expanded="false" aria-controls="calcalute-shipping-wrap" style="color: red">Calculate Shipping Cost Here</a></h2> -->

                                        <section id="calcalute-shipping-wrap" class=" collapse">

                                            <div class="col-md-3 form-row form-row-wide ">
                                                <p class="form-row form-row-wide">
                                                    <select class="form-control" id="shipping_country" name="shipping_country">
                                                        <?php
                                                        foreach ($countries['data'] as $country) {
                                                        ?>
                                                            <option <?php if ($country->id == 153) echo 'selected'; ?> value="<?php echo $country->name; ?>"><?php echo $country->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </p>
                                                    
                                            </div>

                                            <div class="col-md-3">
                                                <p class="form-row form-row-wide">
                                                    <select class="form-control" id="shipping_state" name="shipping_state">
                                                        <option value="">state</option>
                                                        <?php
                                                        foreach ($states['data'] as $state) {
                                                        ?>
                                                            <option value="<?php echo $state->name; ?>"><?php echo $state->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </p>
                                            </div>

                                            <div class="col-md-3" id="calculated-amount" style="display: none;
                                            ">
                                                <p class="form-row form-row-wide">
                                                    <input type="text" class="form-control" readonly="" id="calculated_amount">
                                                </p>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="col-md-3">
                                                <p>
                                                    <button type="button" id="calculate_shipping_cost_submit" class="add_to_cart_button">Update Totals</button>
                                                </p>
                                            </div>
                                            
                                        </section>
                                        <div class="col-md-12">&nbsp;</div>
                                    <?php
                                    } else {
                                        echo '<h3 style="color: green">Use a different shipping address? <a href="shipping-addresses">Click Here</a></h3>';
                                    }
                                    ?>

                                    <input type="hidden" id="shippings" value="<?php echo $shippings; ?>">
                                    <h3 id="order_review_heading">Your order</h3>
                                    <div id="order_review" style="position: relative;">
                                        <table class="shop_table">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Product</th>
                                                    <th class="product-total">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $n = 1; $total_amount = 0;
                                                foreach ($carts as $cart) {
                                                    $images = explode("|", $cart->image_urls);
                                                    $total_amount += $cart->total_amount;
                                                ?>
                                                    <tr class="cart_item">
                                                        <td class="product-name">
                                                            <?php echo $cart->name; ?> <strong class="product-quantity">(<?php echo $cart->amount; ?> × <?php echo $cart->qty; ?>)</strong> </td>
                                                        <td class="product-total">
                                                            <span class="amount">N<?php echo number_format(($cart->amount * $cart->qty),2); ?></span> </td>
                                                    </tr>
                                                <?php 
                                                    $n++;
                                                } 
                                                ?>
                                            </tbody>
                                            <tfoot>

                                                <tr class="cart-subtotal">
                                                    <th>Cart Subtotal</th>
                                                    <td><span class="amount">N<?php echo number_format($total_amount,2);?></span>
                                                    </td>
                                                </tr>

                                                <tr class="shipping">
                                                    <th>Shipping and Handling</th>
                                                    <td id="shipping_cost"><?php if(isset($shipping->amount)){
                                                        echo $shipping->amount;
                                                    } else echo 'Free Shipping';?></td>
                                                </tr>


                                                <tr class="order-total">
                                                    <th>Order Total</th>
                                                    <td><strong>
                                                        <input type="hidden" id="sub_total" value="<?php echo $total_amount; ?>">
                                                        <?php if (isset($shipping->price)) {
                                                            $total_amount += $shipping->price;
                                                        } ?>
                                                        <span class="amount" id="total_amount">N<?php echo number_format($total_amount,2);?></span></strong> 
                                                    </td>
                                                </tr>

                                            </tfoot>
                                        </table>


                                        <div id="payment">
                                            <h3 id="response" style="color: red; font-weight: bold;"></h3>
                                            <!-- <ul class="payment_methods methods">
                                                <li class="payment_method_bacs">
                                                    <input type="radio" data-order_button_text="" checked="checked" value="bacs" name="payment_method" class="input-radio" id="payment_method_bacs">
                                                    <label for="payment_method_bacs">Direct Bank Transfer </label>
                                                    <div class="payment_box payment_method_bacs">
                                                        <p>Make your payment directly into our bank account below. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                                        <p>Account Name: Redjic Collection<br>
                                                            Account No: 1017656796 <br>
                                                        Bank Name: Zenith Bank</p>
                                                    </div>
                                                </li>
                                            </ul> -->

                                            <div class="form-row place-order">
                                                <button type="button" class="add_to_cart_button wc-forward" id="place_order_submit">Make Payment</button>

                                                <input type="hidden" class="shipping_id" id="shipping_id" name="shipping_id" value="<?php echo $shipping_id; ?>">
                                                <input type="hidden" id="transaction_id" name="transaction_id">
                                                <input type="hidden" value="created" name="type">
                                                <button type="submit" id="pay_with_paystack" class="btn btn-sqr" style="display: none;">pay with paystack</button>
                                                <input type="hidden" id="registered_name" value="<?php if(isset($_SESSION['fullname'])) echo $_SESSION['fullname']; ?>">
                                                <input type="hidden" id="registered_email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
                                                <input type="hidden" id="registered_phone" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>">
                                            </div>

                                            <div class="clear"></div>

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

        <script src="js/pages/order/place-order.js?p=<?php echo rand();?>" type="text/javascript"></script>
        <script src="js/pages/login/login.js?p=<?php echo rand();?>" type="text/javascript"></script>

        <script type="text/javascript">
            $("#transaction_id2").val(getTransactionId());
            $(".device_id").val(getCookie("device_id"));
            $(".device_name").val(getCookie("device_name"));
        </script>

    </body>
</html>