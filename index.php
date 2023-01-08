<?php
require_once("config.php");

$page_title = "home";

// $products = $productInstance->getRecentProducts(0, 10);
// $products = $products['data'];

$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : null;
$page = isset($_GET['page'])?$_GET['page']:1;
$perpage = 50;
$pagination = array("page"=>$page, "perpage"=>$perpage);

$products = array();
if ($keywords) {
    $products = $productInstance->getProductsSearch($keywords);
} else $products = $productInstance->getFrontendProducts($pagination);

$current_total = $products['meta']['current_total_records'];
$total = $products['meta']['total'];
$page = $products['meta']['page'];
$pages = $products['meta']['pages'];
$first = $page;
if ($page > 1)
    $first = ($page - 1) * $perpage + 1;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $site_title; ?></title>
        <meta name="robots" content="index, follow" />
        <meta property="og:type" content="product" />
        <meta property="og:site_name" content="<?php echo $site_title; ?>" />
        <meta property="og:title" content="Giftcorner NG |  Online Shopping for household items!" />
        <meta property="og:description" content="Giftcorner NG the #1 Shopping Mall in Nigeria - Shop Online for All Kinds of household items &amp; Enjoy Great Prices And Offers | Secure Payments - Fast Delivery - Free Returns" />
        <meta property="og:url" content="<?php echo $url_endpoint; ?>" />
        <meta property="og:image" content="<?php echo $url_endpoint; ?>img/gift-corner-ng-logo.jpg" />
        <meta property="og:locale" content="en_NG" />
        <meta name="title" content="Giftcorner NG |  Online Shopping for household items!" />
        <meta name="robots" content="index, follow" />
        <meta name="description" content="Giftcorner NG the #1 Shopping Mall in Nigeria - Shop Online for All Kinds of household items &amp; Enjoy Great Prices And Offers | Secure Payments - Fast Delivery - Free Returns" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta Keyword -->
        <meta name="keywords" content="Giftcorner, gift corner, Giftcorner ng, household items, household products, kitchen utensils, freezer bag, toilet bowl cleaner, bathroom self organizer, dishwasher pods, bubble gun, floor & window cleaner, book shelf, dryer sheets, heater pad, fabric sotfener, trash bags, turbo pump, toilet seat cover, dish soap, paper towel, toilet paper, washers & dryers, kettles, blenders, kitchen pots, spoons, refrigerator organizer, magnetic curtain holder, spin mop, diy clock, wine cover, rotating phone holder, meat pie maker, back stretcher massager"/>

        <?php require_once 'css-header.php'; ?>

        <style type="text/css">
            .flex-container{
                /*width: 80%;*/
                min-height: 300px;
                margin: 0 auto;
                display: -webkit-flex; /* Safari */     
                display: flex; /* Standard syntax */
            }

            .row1 {
                display: flex; /* equal height of the children */
            }

            .col {
                flex: 1; /* additionally, equal width */
                min-height: 700px;
                padding: 1em;
                border: solid;
            }
        </style>
    </head>
    <body>
   
        <!-- Header Area -->
        <?php require_once 'header.php'; ?>
        <!-- End header area -->
        
        <!-- Slider -->
        <div class="slider-area">
            <div class="block-slider block-slider4">
                <ul class="" id="bxslider-home4">
                    <li><img src="admin/assets/media/slides/giftcorner-banner.jpg" alt="Slide"></li>
                    <li><img src="admin/assets/media/slides/giftcorner-banner-3.jpg" alt="Slide"></li>
                    <li><img src="admin/assets/media/slides/giftcorner-banner-2.jpg" alt="Slide"></li>
                </ul>
            </div>
        </div> 
        <!-- End slider area -->
        
        <div class="single-product-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    <?php
                    foreach ($products['data'] as $product) {
                    ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="single-shop-product">
                                <div class="product-upper" style="text-align: center;">
                                    <a href="product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>">
                                        <?php
                                        $images = explode("|", $product->image_urls);
                                        ?>

                                        <?php
                                        $file_ext = getFileExt($productImages.$images[0]);
                                        if (!in_array($file_ext, $images_ext)) {
                                            ?>
                                            <video style="width: 300px; height: 300px;" controls autoplay muted>
                                                <source src="<?php echo $productImages.$images[0]; ?>" type="video/<?php echo $file_ext; ?>">
                                                Your browser does not support this video.
                                            </video>
                                        <?php
                                        } else {
                                            ?>
                                            <img src="<?php echo $productImages.$images[0]; ?>" alt="<?php echo $product->name; ?>" <?php if($product->status != 1) echo 'title="Out of stock"';?> style="width: 300px; height: 300px;">
                                        <?php
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div style="min-height: 70px; max-height: 70px;">
                                    <h2 style="text-align: center;"><a href="product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>" <?php if($product->status != 1) echo 'title="Out of stock"';?>><?php echo $product->name; ?></a></h2>
                                </div>
                                <div class="product-carousel-price" style="text-align: center;">
                                    <?php
                                    if ($product->product_off != 0) {
                                    ?>
                                        <ins>NGN <?php echo number_format(($product->price - (($product->product_off/100)*$product->price)),2); ?></ins> <del>NGN <?php echo number_format($product->price,2); ?></del>
                                    <?php
                                    } else {
                                    ?>
                                        NGN <?php echo number_format($product->price,2); ?>
                                    <?php
                                    }
                                    ?>
                                    
                                </div>  
                                
                                <div class="product-option-shop" style="text-align: center;">
                                    <?php
                                    if ($product->status == 1) {
                                    ?>
                                        <button class="add_to_cart_button" onclick="return addItemToCartFromAnyWhere(<?php echo $product->id; ?>)">Add to cart</button>
                                    <?php
                                    } else {
                                    ?>
                                        <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="<?php echo $product->id; ?>" rel="nofollow" style="background: #CCC" title="Out of stock">Add to cart</a>
                                    <?php
                                    }
                                    ?>
                                    
                                </div>                       
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                        
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="product-pagination text-center">
                            <nav>
                              <ul class="pagination">
                                <?php
                                $previous = $next = "1";
                                if($page > 1) 
                                    $previous = $page - 1;

                                if($pages > 1)
                                    $next = $page + 1;
                                ?>
                                <li>
                                    <a href="./?page=<?php echo $previous; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                $last = 1;
                                for ($i=1; $i <= $pages; $i++) { 
                                    $last = $i;
                                ?>
                                    <li <?php if($page == $i){ ?> class="active" <?php }?>>
                                        <a href="./?page=<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php
                                }

                                if (($next -1) == $last) 
                                    $next = ($next -1).'#';
                                ?>
                                <li><a class="next" href="./?page=<?php echo $next; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                              </ul>
                            </nav>                        
                        </div>
                    </div>
                </div>
                
            </div>
        </div><!-- End main content area -->
        
        <!-- Promo area -->
        <div class="promo-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="single-promo promo1">
                            <i class="fa fa-refresh"></i>
                            <p>30 Days return</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-promo promo2">
                            <i class="fa fa-truck"></i>
                            <p>Affordable shipping</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-promo promo3">
                            <i class="fa fa-lock"></i>
                            <p>Secure payments</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-promo promo4">
                            <i class="fa fa-gift"></i>
                            <p>New products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <!-- End promo area -->

        <!-- Footer Area -->
        <?php require_once 'footer.php'; ?>
        <!-- End Footer area -->

        <!-- Js Area -->
        <?php require_once 'footer-js.php'; ?>
        <!-- End Js area -->
    
    </body>
</html>