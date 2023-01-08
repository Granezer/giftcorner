<?php
if(!defined('Header')) {
   die('Direct access not permitted');
}
?>
    <div class="header-area" style="background: #dfb802; color: #fff">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
                            <?php
                            if ($is_login) {
                            ?>
                                <li><a href="my-account" <?php if($page_title=='my-account') echo 'style="color: #FCF3CF"';?>><i class="fa fa-user"></i> My Account</a></li>
                            <?php
                            } 
                            ?>
                            
                            <!-- <li><a href="cart" <?php if($page_title=='cart') echo 'style="color: #FCF3CF"';?>><i class="fa fa-shopping-cart"></i> My Cart</a></li> -->
                            <li><a id="checkout_link" style="display: none;" href="checkout" <?php if($page_title=='checkout') echo 'style="color: #FCF3CF"';?>><i class="fa fa-user"></i> Checkout</a></li>

                            <?php
                            if ($is_login) {
                            ?>
                                <li><a href="order-history" <?php if($page_title=='order-history') echo 'style="color: #FCF3CF"';?>><i class="fa fa-heart"></i> Order History</a></li>
                                <!-- <li><a href="logout"><i class="fa fa-lock"></i> Logout</a></li> -->
                            <?php
                            } else {
                            ?>
                               <li><a href="login" <?php if($page_title=='login') echo 'style="color: #FCF3CF"';?>><i class="fa fa-unlock"></i> Login</a></li>
                                <li><a href="sign-up" <?php if($page_title=='sign-up') echo 'style="color: #FCF3CF"';?>><i class="fa fa-user"></i> Signup</a></li> 
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="header-right">
                        <ul class="list-unstyled list-inline">
                            <li class="dropdown dropdown-small">
                                <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><span class="key">currency :</span><span class="value">NGN </span><b class="caret"></b></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Site branding area -->
    <div class="site-branding-area" style="background: #000;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="./"><img src="img/gift-corner-ng-logo.png" style="width: 96px; height: 64px;"></a></h1>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="shopping-item">
                        <a href="cart">Cart - <span class="cart-amunt">N0</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">0</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!-- End site branding area -->
    
    <!-- Mainmenu Area -->
   <!--  <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li <?php if($page_title=='home') echo 'class="active"';?>><a href="index">Home</a></li>
                        <li <?php if($page_title=='products') echo 'class="active"';?>><a href="products">Products</a></li>
                        <li <?php if($page_title=='cart') echo 'class="active"';?>><a href="cart">Cart</a></li>
                        <li <?php if($page_title=='about-us') echo 'class="active"';?>><a href="about-us">About Us</a></li>
                        <li <?php if($page_title=='contact-us') echo 'class="active"';?>><a href="contact-us">Contact Us</a></li>
                        <?php
                        if (!isset($_SESSION['user_id']) and !isset($_SESSION['user_ses_id'])) {
                        ?>
                            <li <?php if($page_title=='sign-up') echo 'class="active"';?>><a href="sign-up">Sign Up</a></li>
                            <li <?php if($page_title=='login') echo 'class="active"';?>><a href="login">Login</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>  
            </div>
        </div>
    </div>  -->
    <!-- End mainmenu area -->