<?php
require_once("config.php");

$page_title = "payment-history";
$_SESSION["redirect"] = "make-payment";

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
} catch (Exception $e) {
    header("Location: order-history");
} 

if (empty($order)) {
    header("Location: order-history");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Make Payment - <?php echo $site_title; ?></title>

    <!-- Author Meta -->
    <meta name="author" content="Redjic Solutions">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Make Payment - <?php echo $site_title; ?>" />

    <!-- Meta Description -->
    <meta property="og:description" content="<?php echo $site_title; ?> is in partnership with PURE. We believe in giving the body what it needs to thrive with quality products that support nutrition, performance and life balance. PURE utilizes the best ingredients sourced across the globe to create products that work!." />

    <meta property="og:url" content="<?php echo $url_endpoint; ?>make-payment/" />
    <meta property="og:site_name" content="<?php echo $site_title; ?>" />
    <meta property="og:image" content="<?php echo $url_endpoint; ?>img/govic-solutions-logo.jpg" />

    <!-- Meta Keyword -->
    <meta name="keywords" content="new shipping address, about pure, pure products, pure product, people united reaching everyone, boost your immune system, immune system, best vitamins, best vitamin, supplements, best supplements, best supplement, probiotics, and super fruits, boost your skin’s, rejuvenating, younger-looking, more radiant skin, pure websites, pure website, organic products, organic product, weak erection, early ejaculation, diabetics, cancer treatment, treatment of cancer, high bp, low sugar level, high sugar level, cleanse, organic sulfur, sleeptrim, purxcel, daily build, goyin, mila foods, mila food, mila, people united reaching everyone, reduce weight, weight loss, govic, govic solutions, govic solution, govic products, govic solutions product, govic solutions products, treatment of eye problem, treatment of glaucoma, glaucoma, eye problems, health challenges"/>
    
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
                        <h2>Make Payment</h2>
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
                            <form enctype="multipart/form-data" class="checkout" id="make_payment">

                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Make Payment</h3>
                                            <h5 id="response" style="color: red; font-weight: bold;"></h5>

                                            <p class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
                                                <label class="" for="state">Type <abbr title="required" class="required">*</abbr></label>
                                                <select class="" id="direct_transfer_type" name="direct_transfer_type" onchange="return paymentType();">
                                                    <option value="">Select</option>
                                                    <option value="deposit">Payment Details</option>
                                                    <!-- <option value="screenshot">Upload Screenshot</option> -->
                                                    </select>
                                            </p>
                                            <div class="clear"></div>

                                            <div id="deposit" style="display: none">
                                                <p class="form-row form-row-wide acc_name-field validate-required">
                                                    <label class="" for="acc_name">Acc Name <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="Street acc_name" id="acc_name" name="acc_name" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-first validate-required validate-bank_name">
                                                    <label class="" for="bank_name">Bank Name <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="" id="bank_name" name="bank_name" class="input-text ">
                                                </p>

                                                <p class="form-row form-row-last validate-required validate-transaction_reference_no">
                                                    <label class="" for="transaction_reference_no">Transaction Ref <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="text" value="" placeholder="" id="transaction_reference_no" name="transaction_reference_no" class="input-text ">
                                                </p>
                                            </div>
                                            
                                            <div id="screenshots" style="display: none">
                                                <p class="form-row form-row-last validate-required validate-screenshot">
                                                    <label class="" for="screenshot">Screenshot <abbr title="required" class="required">*</abbr>
                                                    </label>
                                                    <input type="file" id="screenshot" name="screenshot">
                                                </p>
                                            </div>

                                            <p class="form-row form-row-last validate-required validate-amount">
                                                <label class="" for="amount">Amount Paid <abbr title="required" class="required">*</abbr>
                                                </label>
                                                <input type="text" value="" placeholder="" id="amount" name="amount" class="input-text ">
                                            </p>
                                            <div class="clear"></div>

                                            <p>
                                                <input type="hidden" name="transaction_id" class="transaction_id">
                                                <input type="hidden" name="user_id" class="user_id">
                                                <input type="hidden" name="user_ses_id" class="user_ses_id">
                                                <input type="hidden" name="reference_no" value="<?php echo $reference_no; ?>">
                                                <label>&nbsp;</label>
                                                <button type="button" id="direct_transfer_submit" class="add_to_cart_button">Save Payment</button>
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

    <script src="js/pages/order/payment.js?p=<?php echo rand();?>" type="text/javascript"></script>
  </body>
</html>