<?php
$id  = isset($_GET["id"]) ? $_GET["id"] : 0;
$recent_products = $productInstance->getRecentProducts($id);
$recent_products = $recent_products['data'];
?>
<div class="single-sidebar">
    <h2 class="sidebar-title">Search Products</h2>
    <form action="products" method="get">
        <input type="text" placeholder="Search products..." name="keywords">
        <input type="submit" value="Search">
    </form>
</div>

<div class="single-sidebar">
    <h2 class="sidebar-title">Products</h2>
    <?php
    foreach ($recent_products as $recent_product) {
        $images = explode("|", $recent_product->image_urls);
    ?>
        <div class="thubmnail-recent">
            <!-- <img src="<?php echo $productImages.$images[0]; ?>" alt="" <?php if($recent_product->status != 1) echo 'title="Out of stock"';?> style="width: 80px; height: 80px;" class="recent-thumb"> -->
            <?php
            $file_ext = getFileExt($productImages.$images[0]);
            if (!in_array($file_ext, $images_ext)) {
                ?>
                <video style="width: 80px; height: 80px;" class="recent-thumb" controls autoplay muted>
                    <source src="<?php echo $productImages.$images[0]; ?>" type="video/<?php echo $file_ext; ?>">
                    Your browser does not support this video.
                </video>
            <?php
            } else {
                ?>
                <img src="<?php echo $productImages.$images[0]; ?>" alt="<?php echo $recent_product->name; ?>" <?php if($recent_product->status != 1) echo 'title="Out of stock"';?> style="width: 80px; height: 80px;" class="recent-thumb">
            <?php
            }
            ?>
            <h2><a href="product-details?id=<?php echo $recent_product->id; ?>&name=<?php echo $recent_product->name; ?>&code=<?php echo md5($recent_product->name); ?>"><?php echo $recent_product->name; ?></a></h2>
            <div class="product-sidebar-price">
                <?php
                if ($recent_product->product_off != 0) {
                    $percent = (float) str_replace(",", '', $recent_product->product_off);
                    $amount = (float) str_replace(",", '', $recent_product->price);
                    $recent_product->product_off = number_format(($amount * ((100 - $percent)/100)), 2);
                ?>
                    <ins>N<?php echo $recent_product->product_off; ?></ins> <del>N<?php echo number_format($recent_product->price,2); ?></del>
                <?php
                } else {
                ?>
                    N<?php echo number_format($recent_product->price,2); ?>
                <?php
                }
                ?>
            </div>                             
        </div>
    <?php
    }
    ?>
        
</div>