<?php
require_once("config.php");

$page_title = "products";
$id  = isset($_GET["id"]) ? $_GET["id"] : 0;

if (empty($id)) {
    header("Location: products");
    exit;
}

$product = $productInstance->getProduct($id);
$product = $product['data'];

$related_products = $productInstance->getRelatedProducts($id);
$related_products = $related_products['data'];

$images = explode("|", trim($product->image_urls, " |"));
// echo json_encode($images[1]);exit;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $product->name; ?> - <?php echo $site_title; ?></title>

    <!-- Author Meta -->
    <meta name="author" content="Redjic Solutions">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $product->name; ?> - <?php echo $site_title; ?>" />

    <!-- Meta Description -->
    <meta property="og:description" content="<?php echo $product->short_desc; ?>" />

    <meta property="og:url" content="<?php echo $url_endpoint; ?>product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>" />
    <meta property="og:site_name" content="<?php echo $site_title; ?>" />
    <meta property="og:image" content="<?php echo $productImages.$images[0]; ?>" />

    <!-- Meta Keyword -->
    <meta name="keywords" content="about pure, pure products, pure product, people united reaching everyone, boost your immune system, immune system, best vitamins, best vitamin, supplements, best supplements, best supplement, probiotics, and super fruits, boost your skin’s, rejuvenating, younger-looking, more radiant skin, pure websites, pure website, organic products, organic product, weak erection, early ejaculation, diabetics, cancer treatment, treatment of cancer, high bp, low sugar level, high sugar level, cleanse, organic sulfur, sleeptrim, purxcel, daily build, goyin, mila foods, mila food, mila, people united reaching everyone, reduce weight, weight loss, govic, govic solutions, govic solution, govic products, govic solutions product, govic solutions products, treatment of eye problem, treatment of glaucoma, glaucoma, eye problems, health challenges"/>
    
    <?php require_once 'css-header.php'; ?>
  </head>
  <body>
   
    <!-- Header Area -->
    <?php require_once 'header.php'; ?>
    <!-- End header area -->
    
 <!--    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Product Details</h2>
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
                        <div class="product-breadcroumb">
                            <a href="index">Home</a>
                            <a href=""><?php echo $product->name; ?></a>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <!-- <img src="<?php echo $productImages.$images[0]; ?>" alt="" <?php if($product->status != 1) echo 'title="Out of stock"';?>> -->
                                        <?php
                                        $file_ext = getFileExt($productImages.$images[0]);
                                        if (!in_array($file_ext, $images_ext)) {
                                            ?>
                                            <video style="width: 300px; height: 250px;" controls autoplay>
                                                <source src="<?php echo $productImages.$images[0]; ?>" type="video/<?php echo $file_ext; ?>">
                                                Your browser does not support this video
                                            </video>
                                        <?php
                                        } else {
                                            ?>
                                            <img src="<?php echo $productImages.$images[0]; ?>" alt="<?php echo $product->name; ?>" <?php if($product->status != 1){ echo 'title="Out of stock"';}?>>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if (isset($images[1])) {
                                        $count = count($images);
                                    ?>
                                        <div class="product-gallery">
                                            <?php
                                            for ($i=0; $i < $count; $i++) { 
                                            ?>
                                                <img src="<?php echo $productImages.$images[$i]; ?>" alt="" <?php if($product->status != 1) echo 'title="Out of stock"';?>>
                                            <?php
                                            }
                                            ?>
                                    <?php
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name"><?php echo $product->name; ?></h2>
                                    <div class="product-inner-price">
                                        <?php
                                        if ($product->product_off != 0) {
                                        ?>
                                            <ins>N<?php echo $product->product_off; ?></ins> <del>N<?php echo $product->price; ?></del>
                                        <?php
                                        } else {
                                        ?>
                                            N<?php echo $product->price; ?>
                                        <?php
                                        }
                                        ?>
                                    </div>   
                                    
                                    <div class="product-inner-category">
                                        <p><?php echo $product->short_desc; ?></p>
                                        <p> Tags: <a href="">awesome</a>, <a href="">best</a>, <a href="">sale</a>, <a href="">shoes</a>. </p>
                                    </div>    
                                    
                                    <form action="" class="cart">
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" id="qty" min="1" step="1">
                                            <input type="hidden" value="<?php echo $product->id; ?>" id="product_id">
                                        </div>
                                        <?php
                                        if ($product->status == 1) {
                                        ?>
                                            <button type="button" class="add_to_cart_button" onclick="return addCart()">Add to cart</button>
                                        <?php
                                        } else {
                                        ?>
                                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="<?php echo $product->id; ?>" rel="nofollow" style="background: #CCC" title="Out of stock">Add to cart</a>
                                        <?php
                                        }
                                        ?>
                                    </form> 
                                    
                                    
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                                        <li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab">Reviews</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <p><?php echo $product->description; ?></p>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="review">
                                            <h2>Reviews</h2>
                                            <div class="submit-review">
                                                <p><label for="name">Name</label> <input name="name" type="text"></p>
                                                <p><label for="email">Email</label> <input name="email" type="email"></p>
                                                <div class="rating-chooser">
                                                    <p>Your rating</p>

                                                    <div class="rating-wrap-post">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
                                                <p><input type="submit" value="Submit"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <p style="color:red;">These statements have not been evaluated by the Food and Drug Administration.
                                    Products are not intended to diagnose, treat, cure, or prevent any disease.
                                </div>
                            </div>
                        </div>
                        
                        <?php
                        if ($related_products) {
                        ?>
                            <div class="related-products-wrapper">
                                <h2 class="related-products-title">Related Products</h2>
                                <div class="related-products-carousel">
                                    <?php
                                    foreach ($related_products as $product) {
                                        $images = explode("|", trim($product->image_urls, " |"));
                                    ?>
                                        <div class="single-product">
                                            <div class="product-f-image">
                                                <!-- <img src="<?php echo $productImages.$images[0]; ?>" alt="" style="width: 300px; height: 300px;"> -->
                                                <?php
                                                $file_ext = getFileExt($productImages.$images[0]);
                                                if (!in_array($file_ext, $images_ext)) {
                                                    ?>
                                                    <video style="width: 300px; height: 300px;" controls autoplay>
                                                        <source src="<?php echo $productImages.$images[0]; ?>" type="video/<?php echo $file_ext; ?>">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo $productImages.$images[0]; ?>" alt="" <?php if($product->status != 1) echo 'title="Out of stock"';?> style="width: 300px; height: 300px;">
                                                <?php
                                                }
                                                ?>
                                                <div class="product-hover">
                                                    <?php
                                                    if ($product->status == 1) {
                                                    ?>
                                                        <a class="add-to-cart-link" onclick="return addItemToCartFromAnyWhere(<?php echo $product->id; ?>)"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a class="add-to-cart-link" style="background: #CCC" title="Out of stock"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                    <?php
                                                    }
                                                    ?>

                                                    <a href="product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                                </div>
                                            </div>

                                            <h2 style="text-align: center;"><a href="product-details?id=<?php echo $product->id; ?>&name=<?php echo $product->name; ?>&code=<?php echo md5($product->name); ?>"><?php echo $product->name; ?></a></h2>

                                            <div class="product-carousel-price" style="text-align: center;">
                                                <?php
                                                if ($product->product_off != 0) {
                                                ?>
                                                    <ins>N<?php echo $product->product_off; ?></ins> <del>N<?php echo $product->price; ?></del>
                                                <?php
                                                } else {
                                                ?>
                                                    N<?php echo $product->price; ?>
                                                <?php
                                                }
                                                ?>
                                            </div> 
                                        </div> 
                                    <?php
                                    }
                                    ?>                                    
                                </div>
                            </div>
                        <?php
                        }
                        ?>  
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
  </body>
</html>