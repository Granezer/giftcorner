<div class="single-sidebar">
    <h2 class="sidebar-title">Quick Links</h2>
    <ul>
        <li><a href="my-account" <?php if($page_title=='my-account') echo 'style="color: #fead53"';?>>Dashboard</a></li>
        <li><a href="profile" <?php if($page_title=='profile') echo 'style="color: #fead53"';?>>Edit My Profile</a></li>
        <li><a href="order-history" <?php if($page_title=='order-history') echo 'style="color: #fead53"';?>>Order History</a></li>
        <li><a href="cart" <?php if($page_title=='cart') echo 'style="color: #fead53"';?>>My Cart</a></li>
        <!-- <li><a href="wishlist" <?php if($page_title=='wishlist') echo 'style="color: #fead53"';?>>My Wishlists</a></li> -->
        <li><a href="payment-history" <?php if($page_title=='payment-history') echo 'style="color: #fead53"';?>>
        Payment History</a></li>
        <li><a href="shipping-addresses" <?php if($page_title=='shipping-addresses') echo 'style="color: #fead53"';?>>Shipping Addresses</a></li>
        <li><a href="logout">Logout</a></li>
    </ul>
</div>