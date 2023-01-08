<?php 
require_once("config.php"); 

$header = "dashboard";

$params = http_build_query($params);
$recent_payments = file_get_contents($end_point . "get-recent-payments.php?" . $params);
$recent_payments = json_decode($recent_payments, true);

$recent_users = file_get_contents($end_point . "get-recent-user.php?" . $params);
$recent_users = json_decode($recent_users, true);

$recent_products = file_get_contents($end_point . "get-recent-products.php?" . $params);
$recent_products = json_decode($recent_products, true);

$best_sellings = file_get_contents($end_point . "get-best-selling-products.php?" . $params."&limit=3");
$best_sellings = json_decode($best_sellings, true);

// echo json_encode($recent_payments); exit;
?>

<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>Dashboard | <?php echo $site_title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<?php require_once("head-css.php"); ?>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<?php require_once("header-mobile.php");?>
		<!-- end:: Header Mobile -->

		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">

					<!-- begin:: Header -->
					<?php require_once("header.php");?>
					<!-- end:: Header -->

					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
						<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
							<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

								<!-- begin:: Content Head -->
								<div class="kt-subheader   kt-grid__item" id="kt_subheader">
									<div class="kt-container ">
										<div class="kt-subheader__main">
											<h3 class="kt-subheader__title">Dashboard</h3>
										</div>
									</div>
								</div>

								<!-- end:: Content Head -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">

									<!--Begin::Dashboard 2-->

									<!--Begin::Row-->
									<div class="row">
										<div class="col-xl-4 col-lg-4">

											<!--begin:: Widgets/Daily Sales-->
											<div class="kt-portlet kt-portlet--height-fluid">
												<div class="kt-widget14">
													<div class="kt-widget14__header kt-margin-b-30">
														<h3 class="kt-widget14__title">
															Products
														</h3>
														<span class="kt-widget14__desc">
															Check out each collumn for more details
														</span>
													</div>
													<div class="kt-widget14__chart" style="height:120px;">
														<canvas id="kt_chart_products"></canvas>
													</div>
												</div>
											</div>

											<!--end:: Widgets/Daily Sales-->
										</div>
										<div class="col-xl-4 col-lg-4">

											<!--begin:: Widgets/Profit Share-->
											<div class="kt-portlet kt-portlet--height-fluid">
												<div class="kt-widget14">
													<div class="kt-widget14__header">
														<h3 class="kt-widget14__title">
															Orders
														</h3>
														<span class="kt-widget14__desc">
															All Orders
														</span>
													</div>
													<div class="kt-widget14__content">
														<div class="kt-widget14__chart">
															<div class="kt-widget14__stat" id="highest_order"></div>
															<canvas id="kt_chart_orders" style="height: 140px; width: 140px;"></canvas>
														</div>
														<div class="kt-widget14__legends">
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-dark"></span>
																<span class="kt-widget14__stats" id="awaiting_payment"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-warning"></span>
																<span class="kt-widget14__stats" id="pending"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-success"></span>
																<span class="kt-widget14__stats" id="delivered"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-danger"></span>
																<span class="kt-widget14__stats" id="cancelled"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-brand"></span>
																<span class="kt-widget14__stats" id="accepted"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-info"></span>
																<span class="kt-widget14__stats" id="pending_pickup"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-primary"></span>
																<span class="kt-widget14__stats" id="pending_delivery"></span>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--end:: Widgets/Profit Share-->
										</div>
										<div class="col-xl-4 col-lg-4">

											<!--begin:: Widgets/Revenue Change-->
											<div class="kt-portlet kt-portlet--height-fluid">
												<div class="kt-widget14">
													<div class="kt-widget14__header">
														<h3 class="kt-widget14__title">
															Payments
														</h3>
														<span class="kt-widget14__desc">
															user payments
														</span>
													</div>
													<div class="kt-widget14__content">
														<div class="kt-widget14__chart">
															<div id="kt_chart_user_payments" style="height: 150px; width: 150px;"></div>
														</div>
														<div class="kt-widget14__legends">
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-warning"></span>
																<span class="kt-widget14__stats" id="payment_pending"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-success"></span>
																<span class="kt-widget14__stats" id="payment_confirmed"></span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet kt-bg-danger"></span>
																<span class="kt-widget14__stats" id="payment_cancelled"></span>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--end:: Widgets/Revenue Change-->
										</div>
									</div>

									<!--End::Row-->

									<!--Begin::Row-->
									<div class="row">
										<div class="col-xl-8 col-lg-12 order-lg-1 order-xl-1">

											<!--begin:: Widgets/Download Files-->
											<div class="kt-portlet kt-portlet--height-fluid">
												<div class="kt-portlet__head">
													<div class="kt-portlet__head-label">
														<h3 class="kt-portlet__head-title">
															Recent Products
														</h3>
													</div>
												</div>
												<div class="kt-portlet__body">
													<div class="tab-content">
														<div class="tab-pane active" id="kt_widget4_tab1_content">
															<div class="kt-widget4">
																<?php
																foreach ($recent_products['data'] as $recent_product) {
																	$pimage = explode("|", $recent_product['image_urls']);
																	// $category = $recent_product['category'];
																	$pstatus = array("Paused", "Live on site", "Rejected", "Under review");
																	$pstatusBadge = array("danger", "success", "warning", "brand");
																?>
																	<div class="kt-widget4__item">
																		<div class="kt-widget4__pic kt-widget4__pic--pic">
																			<img src="<?php echo $pimage[0];?>" alt="">
																		</div>
																		<div class="kt-widget4__info">
																			<a href="#" class="kt-widget4__username">
																				<?php echo $recent_product['name'];?>
																			</a>
																			<p class="kt-widget4__text">Status: <span class="kt-badge kt-badge--<?php echo $pstatusBadge[$recent_product['status']];?> kt-badge--inline kt-badge--pill"><?php echo $pstatus[$recent_product['status']];?>
																			</span>
																			</p>
																		</div>
																		<?php echo 'NGN '.number_format($recent_product['price'],2);?>
																		&nbsp;&nbsp;&nbsp;
																		<?php echo $recent_product['date_time'];?>
																	</div>
																<?php
																}
																?>
																	
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--end:: Widgets/Download Files-->
										</div>
										<div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1">

											<!--begin:: Widgets/New Users-->
											<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
												<div class="kt-portlet__head">
													<div class="kt-portlet__head-label">
														<h3 class="kt-portlet__head-title">
															Recent Payments
														</h3>
													</div>
												</div>
												<div class="kt-portlet__body">
													<div class="tab-content">
														<div class="tab-pane active" id="kt_widget4_tab1_content">
															<div class="kt-widget4">
																<?php
																foreach ($recent_payments['data'] as $recent_payment) {
																?>
																	<div class="kt-widget4__item">
																		
																		<div class="kt-widget4__info">
																			<a href="#" class="kt-widget4__username">
																				Name: <?php echo $recent_payment['fullname'];?>
																			</a>
																			<p class="kt-widget4__text">
																				Order No: <?php echo $recent_payment['reference_no'];?>
																			</p>
																		</div>
																		NGN <?php echo $recent_payment['amount_paid'];?>
																		&nbsp;&nbsp;&nbsp;
																		<a href="payments/user-payment-details?id=<?php echo $recent_payment['id'];?>" class="btn btn-sm btn-label-brand btn-bold">View</a>
																	</div>
																<?php
																}
																?>
																	
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--end:: Widgets/New Users-->
										</div>
									</div>
									<!--End::Row-->

									<div class="row">
										<div class="col-xl-8 col-lg-12 order-lg-3 order-xl-1">

											<!--begin:: Widgets/Best Sellers-->
											<div class="kt-portlet kt-portlet--height-fluid">
												<div class="kt-portlet__head">
													<div class="kt-portlet__head-label">
														<h3 class="kt-portlet__head-title">
															Best Selling
														</h3>
													</div>
												</div>
												<div class="kt-portlet__body">
													<div class="tab-content">
														<div class="tab-pane active" id="kt_widget5_tab1_content" aria-expanded="true">
															<div class="kt-widget5">
																<?php
																foreach ($best_sellings['data'] as $best_selling) {
																	$pimage = explode("|", $best_selling['image_urls']);
																	$pimage = $pimage[0];
																?>
																	<div class="kt-widget5__item">
																	<div class="kt-widget5__content">
																		<div class="kt-widget5__pic">
																			<img class="kt-widget7__img" src="assets/media/products/<?php echo $pimage; ?>" alt="">
																		</div>
																		<div class="kt-widget5__section">
																			<a href="#" class="kt-widget5__title">
																				<?php echo $best_selling['name']; ?>
																			</a>
																		</div>
																	</div>
																	<div class="kt-widget5__content">
																		<div class="kt-widget5__stats">
																			<span class="kt-widget5__number"><?php echo number_format($best_selling['total_qty']); ?></span>
																			<span class="kt-widget5__sales">sales</span>
																		</div>
																		<div class="kt-widget5__stats">
																			<span class="kt-widget5__number"><?php echo number_format($best_selling['total_amount']); ?></span>
																			<span class="kt-widget5__votes">amount</span>
																		</div>
																	</div>
																</div>
																<?php
																}
																?>
																
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--end:: Widgets/Best Sellers-->
										</div>
										<div class="col-xl-4 col-lg-6 order-lg-3 order-xl-1">

											<!--begin:: Widgets/New Users-->
											<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
												<div class="kt-portlet__head">
													<div class="kt-portlet__head-label">
														<h3 class="kt-portlet__head-title">
															Recent Users
														</h3>
													</div>
												</div>
												<div class="kt-portlet__body">
													<div class="tab-content">
														<div class="tab-pane active" id="kt_widget4_tab1_content">
															<div class="kt-widget4">
																<?php
																foreach ($recent_users['data'] as $recent_user) {

																	$url = "users/user-profile/overview?user_id=".$recent_user['id'];
																	$image = $recent_user['profile_image_url'];

																?>
																	<div class="kt-widget4__item">
																		<div class="kt-widget4__pic kt-widget4__pic--pic">
																			<img src="<?php echo $image;?>" alt="">
																		</div>
																		<div class="kt-widget4__info">
																			<a href="<?php echo $url;?>" class="kt-widget4__username">
																				<?php echo $recent_user['fullname'];?>
																			</a>
																			<p class="kt-widget4__text">
																				<?php echo $recent_user['email'];?>
																			</p>
																		</div>
																		<a href="<?php echo $url;?>" class="btn btn-sm btn-label-brand btn-bold">View</a>
																	</div>
																<?php
																}
																?>
															</div>	
														</div>
													</div>
												</div>
											</div>

											<!--end:: Widgets/New Users-->
										</div>


									</div>

									<!--End::Dashboard 2-->
								</div>

								<!-- end:: Content -->
							</div>
						</div>
					</div>

					<!-- begin:: Footer -->
					<?php require_once("footer.php");?>
					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<?php require_once("footer-js.php");?>

		<!--end::Page Scripts -->
		<script src="assets/js/pages/dashboard.js?pp=<?php echo $remove_cache;?>" type="text/javascript"></script>
	</body>

	<!-- end::Body -->
</html>