<?php
if(!defined('Header')) {
   die('Direct access not permitted');
} 
?>
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
	<div class="kt-header__top" style="background: #000">
		<div class="kt-container ">

			<!-- begin:: Brand -->
			<div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
				<div class="kt-header__brand-logo">
					<a href="dashboard">
						<img alt="Logo" src="assets/media/logos/gift-corner-ng-logo.png" style="height: 45px;" class="kt-header__brand-logo-default" />
					</a>
				</div>
				
			</div>
			<!-- end:: Brand -->

			<!-- begin:: Header Topbar -->
			<div class="kt-header__topbar kt-grid__item kt-grid__item--fluid">

				<!--begin: Notifications -->
				
				<!--end: Notifications -->

				<!--begin: User bar -->
				<div class="kt-header__topbar-item kt-header__topbar-item--user">
					<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
						<span class="kt-hidden kt-header__topbar-welcome">Hi,</span>
						<span class="kt-hidden kt-header__topbar-username"><?php echo $_SESSION['first_name']; ?></span>
						<img class="kt-hidden-" alt="Pic" src="<?php echo $_SESSION['profile_image']; ?>" />
						<span class="kt-header__topbar-icon kt-header__topbar-icon--brand kt-hidden"><b>S</b></span>
					</div>
					<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

						<!--begin: Head -->
						<div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
							<div class="kt-user-card__avatar">
								<img class="kt-hidden-" alt="Pic" src="<?php echo $_SESSION['profile_image']; ?>" />

								<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
								<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
							</div>
							<div class="kt-user-card__name">
								<?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']; ?>
							</div>
							<!-- <div class="kt-user-card__badge">
								<span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
							</div> -->
						</div>

						<!--end: Head -->

						<!--begin: Navigation -->
						<div class="kt-notification">
							<a href="profile/basic-info" class="kt-notification__item">
								<div class="kt-notification__item-icon">
									<i class="flaticon2-calendar-3 kt-font-success"></i>
								</div>
								<div class="kt-notification__item-details">
									<div class="kt-notification__item-title kt-font-bold">
										My Profile
									</div>
									<div class="kt-notification__item-time">
										Account settings and more
									</div>
								</div>
							</a>
							<div class="kt-notification__custom kt-space-between">
								<a href="logout" onclick="return logout();" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
							</div>
						</div>

						<!--end: Navigation -->
					</div>
				</div>

				<!--end: User bar -->
			</div>

			<!-- end:: Header Topbar -->
		</div>
	</div>
	<div class="kt-header__bottom">
		<div class="kt-container ">

			<!-- begin: Header Menu -->
			<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
			<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
				<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
					<ul class="kt-menu__nav ">
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'dashboard'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="dashboard" class="kt-menu__link"><span class="kt-menu__link-text">Dashboards</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>	
						</li>
						
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'employees'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Employees</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="employees/employees" class="kt-menu__link"><i class="kt-menu__link-icon flaticon-users-1"></i><span class="kt-menu__link-text">Employees</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-user-settings"></i><span class="kt-menu__link-text">My Profile</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
										<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
											<ul class="kt-menu__subnav">
												<li class="kt-menu__item " aria-haspopup="true"><a href="profile/basic-info" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Basic Infomation</span></a></li>
												<li class="kt-menu__item " aria-haspopup="true"><a href="profile/contact-info" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Contact Information</span></a></li>
												<li class="kt-menu__item " aria-haspopup="true"><a href="profile/contact-info" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Emergency Contact</span></a></li>
												<li class="kt-menu__item " aria-haspopup="true"><a href="profile/change-password" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Change Password</span></a></li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</li>
						
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'users'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Users</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="users" class="kt-menu__link"><i class="kt-menu__link-icon flaticon-file-2"></i><span class="kt-menu__link-text">Users</span></a>
									</li>
									<!-- <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="users/shipping-address" class="kt-menu__link"><i class="kt-menu__link-icon flaticon-file-2"></i><span class="kt-menu__link-text">Shipping Addresses</span></a>
									</li> -->
									<!-- <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="users/all-activities" class="kt-menu__link"><i class="kt-menu__link-icon flaticon-file-2"></i><span class="kt-menu__link-text">Activities</span></a>
									</li> -->
								</ul>
							</div>
						</li>
						
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'products'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Products</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="products/new-product" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">New Product</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="products/index" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">All Products</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="products/index?status=live" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Live Products</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="products/index?status=paused" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Paused Products</span></a>
									</li>
								</ul>
							</div>
						</li>
						
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'orders'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Orders</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">All</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index?status=delivered" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Delivered</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index?status=awaiting payment" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Awaiting Payment</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index?status=pending" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Pending</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index?status=pending pickup" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Pending Pickup</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index?status=pending delivery" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Pending Delivery</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="orders/index?status=cancelled" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Cancelled</span></a>
									</li>
								</ul>
							</div>
						</li>
						
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'payments'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Payments</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="payments/index" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">All Payments</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="payments/user-payments" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-money-check-alt"></i><span class="kt-menu__link-text">Cancelled Payments</span></a>
									</li>
								</ul>
							</div>
						</li>
						
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'settings'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Settings</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="settings/company-info" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-building"></i><span class="kt-menu__link-text">Company Info</span></a>
									</li>
									<li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="settings/roles" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-building"></i><span class="kt-menu__link-text">Roles</span></a>
									</li>
								</ul>
							</div>
						</li>
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?php if($header == 'dashboard'){ ?>kt-menu__item--open kt-menu__item--here kt-menu__item--open kt-menu__item--here <?php } ?>" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="logout" onclick="return logout();" class="kt-menu__link"><span class="kt-menu__link-text">Logout</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>	
						</li>
					</ul>
				</div>
			</div>

			<!-- end: Header Menu -->
		</div>
	</div>
</div>
