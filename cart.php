<?php
require_once("config.php");

$page_title = "cart";

$user_ses_id = isset($_SESSION['user_ses_id']) 
    ? $_SESSION['user_ses_id'] : $_COOKIE['device_id'];
$user_id = isset($_SESSION['user_id']) 
    ? $_SESSION['user_id'] : null;

$cartInstance = new Users\Carts();
$carts = $cartInstance->getCartItemsBySession($user_id, $user_ses_id, 1);
$total_amount = 0;

// echo json_encode($carts);exit;
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
        
        <!-- <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>Shopping Cart</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>  -->
        <!-- End Page title area -->
        
        <div class="single-product-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-8">
                        <div class="product-content-right">
                            <div class="woocommerce">
                                <form method="post" action="#">
                                    <table cellspacing="0" class="shop_table cart">
                                        <thead>
                                            <tr>
                                                <th class="product-remove">&nbsp;</th>
                                                <th class="product-thumbnail">&nbsp;</th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $product_ids = '';
                                            if ($carts) {
                                                $n = 1; 
                                                foreach ($carts as $cart) {
                                                    $images = explode("|", $cart->image_urls);
                                                    $total_amount += $cart->total_amount;
                                                    $product_ids .= $cart->id .',';

                                                    $amount = number_format($cart->price,2);
                                                    if ($cart->product_off != 0) {
                                                        $amount = (float) str_replace(",", '', $amount);
                                                        $percent = (float) str_replace(",", '', $cart->product_off);
                                                        $amount = number_format(($amount * ((100 - $percent)/100)), 2);
                                                    }
                                            ?>
                                                   <tr class="cart_item">
                                                        <td class="product-remove">
                                                            <a title="Remove this item" class="remove" href="#" onclick="return removeItemFromCart(<?php echo $cart->id; ?>)">×</a> 
                                                            <a title="Move item to wishlist" class="remove" href="#" onclick="return moveItem(<?php echo $cart->id; ?>, 'moved')">+</a> 
                                                        </td>

                                                        <td class="product-thumbnail">
                                                            <a href="product-details?id=<?php echo $cart->id; ?>&name=<?php echo $cart->name; ?>&code=<?php echo md5($cart->name); ?>">
                                                                <!-- <img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="<?php echo $productImages.$images[0]; ?>"> -->
                                                                <?php
                                                                $file_ext = getFileExt($productImages.$images[0]);
                                                                if (!in_array($file_ext, $images_ext)) {
                                                                    ?>
                                                                    <video width="40" height="40" controls class="shop_thumbnail">
                                                                        <source src="<?php echo $productImages.$images[0]; ?>" type="video/<?php echo $file_ext; ?>">
                                                                        Your browser does not support this video.
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
                                                            <span class="amount">N<?php echo $amount; ?></span> 
                                                            <input type="hidden" name="product_id[]" value="<?php echo $cart->id; ?>">
                                                        </td>

                                                        <td class="product-quantity">
                                                            <div class="quantity buttons_added">
                                                                <input type="button" class="minus" value="-" onclick="return decreaseQty(<?php echo $n;?>)">

                                                                <input type="number" size="4" class="input-text qty text" title="Qty" value="<?php echo $cart->qty; ?>" min="0" step="1" name="qty[]" id="qty<?php echo $n;?>">

                                                                <input type="button" class="plus" value="+" onclick="return increaseQty(<?php echo $n;?>)">
                                                            </div>
                                                        </td>

                                                        <td class="product-subtotal">
                                                            <?php $amount = (float) str_replace(",", '', $amount); ?>
                                                            <span class="amount">N<?php echo number_format(($amount * $cart->qty),2); ?></span> 
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    $n++;
                                                } 
                                                ?>
                                                <tr>
                                                    <td class="actions" colspan="6">
                                                        <div class="coupon">
                                                            <label for="coupon_code">Coupon:</label>
                                                            <input type="text" placeholder="Coupon code" value="" id="coupon_code" class="input-text" name="coupon_code">
                                                            <button type="button" class="add_to_cart_button wc-forward" id="apply_coupon_submit">Apply Coupon</button>
                                                        </div>
                                                        <button type="button" class="add_to_cart_button wc-forward" id="update_cart_submit">Update Cart</button>
                                                        <button type="button" class="add_to_cart_button wc-forward" onclick="checkout()">Checkout</button>
                                                    </td>
                                                </tr> 
                                            <?php
                                                $product_ids=rtrim($product_ids,", ");
                                            } else{
                                            ?>
                                                <tr class="cart_item">
                                                    <td colspan="6" style="color: red">
                                                        Cart is empty 
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>  
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="transaction_id" class="transaction_id">
                                    <input type="hidden" name="user_id" class="user_id">
                                    <input type="hidden" name="user_ses_id" class="user_ses_id">
                                    <input type="hidden" name="device_id" class="device_id">
                                    <input type="hidden" name="type" value="update">
                                </form>

                                <div class="cart-collaterals">

                                    
                                    <?php
                                    if(!$product_ids) $product_ids = 0;
                                    $products=$productInstance->getRecommendedProducts($product_ids);
                                    $products = $products['data'];
                                    if ($products) {
                                    ?>
                                        <div class="cross-sells">
                                            <h2>You may be interested in...</h2>
                                            <ul class="products">
                                                <?php
                                                foreach ($products as $product) {
                                                    $images = explode("|", $product->image_urls);
                                                ?>
                                                    <li class="product" style="text-align: center;">
                                                        <a href="product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>">
                                                            <img src="<?php echo $productImages.$images[0]; ?>" alt="" <?php if($product->status != 1) echo 'title="Out of stock"';?> style="width: 225px; height: 225px;" class="attachment-shop_catalog wp-post-image">
                                                            <h3><?php echo $product->name; ?></h3>
                                                            <?php 
                                                            if ($product->product_off != 0) {
                                                                $percent = (float) str_replace(",", '', $product->product_off);
                                                                $amount = (float) str_replace(",", '', $product->price);
                                                                $product->price = ($amount * ((100 - $percent)/100));
                                                            }
                                                            ?>
                                                            <span class="price"><span class="amount">N<?php echo number_format($product->price, 2); ?></span></span>
                                                        </a>

                                                        <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="<?php echo $product->id; ?>" rel="nofollow" href="product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>" <?php if($product->status != 1) echo 'title="Out of stock"';?>>View Details</a>
                                                    </li>
                                                <?php
                                                }
                                                ?>   
                                            </ul>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <div class="cart_totals ">
                                        <h2>Cart Totals</h2>

                                        <table cellspacing="0">
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>Cart Subtotal</th>
                                                    <td><span class="amount">N<?php echo number_format($total_amount,2);?></span></td>
                                                </tr>

                                                <tr class="shipping">
                                                    <th>Shipping and Handling</th>
                                                    <td>Free Shipping</td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>Order Total</th>
                                                    <td><strong><span class="amount">N<?php echo number_format($total_amount,2);?></span></strong> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
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

        <script src="js/pages/cart/checkout.js?p=<?php echo rand();?>" type="text/javascript"></script>
    </body>
</html>