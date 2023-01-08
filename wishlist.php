<?php
require_once("config.php");

$page_title = "wishlist";
$_SESSION["redirect"] = "wishlist";

require_once("is-login.php");

$wishlistInstance = new Users\Wishlists();
$wishlists = $wishlistInstance->getWishlists($user_id);
$wishlists = $wishlists['data'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wishlists - <?php echo $site_title; ?></title>

    <!-- Author Meta -->
    <meta name="author" content="Redjic Solutions">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Wishlists - <?php echo $site_title; ?>" />

    <!-- Meta Description -->
    <meta property="og:description" content="<?php echo $site_title; ?> is in partnership with PURE. We believe in giving the body what it needs to thrive with quality products that support nutrition, performance and life balance. PURE utilizes the best ingredients sourced across the globe to create products that work!." />

    <meta property="og:url" content="<?php echo $url_endpoint; ?>wishlist/" />
    <meta property="og:site_name" content="<?php echo $site_title; ?>" />
    <meta property="og:image" content="<?php echo $url_endpoint; ?>img/govic-solutions-logo.jpg" />

    <!-- Meta Keyword -->
    <meta name="keywords" content="about pure, pure products, pure product, people united reaching everyone, boost your immune system, immune system, best vitamins, best vitamin, supplements, best supplements, best supplement, probiotics, and super fruits, boost your skin’s, rejuvenating, younger-looking, more radiant skin, pure websites, pure website, organic products, organic product, weak erection, early ejaculation, diabetics, cancer treatment, treatment of cancer, high bp, low sugar level, high sugar level, cleanse, organic sulfur, sleeptrim, purxcel, daily build, goyin, mila foods, mila food, mila, people united reaching everyone, reduce weight, weight loss, govic, govic solutions, govic solution, govic products, govic solutions product, govic solutions products, treatment of eye problem, treatment of glaucoma, glaucoma, eye problems, health challenges"/>
    
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
                        <h2>Wishlists</h2>
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
                            <form method="post" action="#">
                                <?php
                                if ($wishlists) {
                                    ?>
                                    <table cellspacing="0" class="shop_table cart">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th class="product-thumbnail">Product Image</th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            foreach ($wishlists as $wishlist) {
                                                $images = explode("|", $wishlist->image_urls);
                                            ?>
                                                <tr class="cart_item">
                                                    <td class="product-remove"><?php echo $n;?></td>

                                                    <td class="product-thumbnail">
                                                        <a href="product-details?id=<?php echo $wishlist->id; ?>&name=<?php echo $wishlist->name; ?>&code=<?php echo md5($wishlist->name); ?>"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="<?php echo $images[0]; ?>"></a>
                                                    </td>

                                                    <td class="product-name">
                                                        <a href="product-details?id=<?php echo $wishlist->id; ?>&name=<?php echo $wishlist->name; ?>&code=<?php echo md5($wishlist->name); ?>"><?php echo $wishlist->name; ?></a> 
                                                    </td>

                                                    <td class="product-price">
                                                        <span class="amount"><?php echo $wishlist->price; ?></span> 
                                                    </td>

                                                    <td class="product-quantity">
                                                        <?php 
                                                        if($wishlist->status == 1) {
                                                        ?>
                                                            <a title="Add this item to cart" href="#" onclick="return moveItem(<?php echo $wishlist->id; ?>, 'removed')"><i class="fa fa-plus"></i> </a> 
                                                            &nbsp;&nbsp;&nbsp;
                                                        <?php
                                                        }
                                                        ?>
                                                        <a title="Remove this item from wishlists" href="#"><i class="fa fa-trash" onclick="return wishlist(<?php echo $wishlist->id; ?>, 1);"></i> </a> 
                                                    </td>
                                                </tr>
                                            <?php
                                                $n++;
                                            }
                                            ?> 
                                        </tbody>
                                    </table>
                                <?php 
                                } else {
                                    echo '<h3>Your wishlist is empty</h3> Click <a href="./">here</a> to add';
                                }
                                ?>
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

    <script src="js/pages/wishlist/index.js?p=<?php echo rand();?>" type="text/javascript"></script>

  </body>
</html>