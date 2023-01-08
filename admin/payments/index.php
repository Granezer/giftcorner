<?php
require_once '../config.php';
$header = "payments";
$pageName = "payments";
?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>Payments | <?php echo $site_title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<?php require_once ("../head-css.php"); ?>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<?php require_once ("../header-mobile.php"); ?>
		<!-- end:: Header Mobile -->

		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">

					<!-- begin:: Header -->
					<?php require_once ("../header.php"); ?>
					<!-- end:: Header -->

					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
						<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
							<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

								<!-- begin:: Content Head -->
								<div class="kt-subheader   kt-grid__item" id="kt_subheader">
									<div class="kt-container ">
										<div class="kt-subheader__main">
											<h3 class="kt-subheader__title">User's Payments</h3>
											
										</div>
									</div>
								</div>

								<!-- end:: Content Head -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">
									<!-- <div class="alert alert-light alert-elevate" role="alert">
										<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
										<div class="alert-text">
											The Metronic Datatable allows the end user to select single or multiple rows using checkbox to perform operations over rows.
										</div>
									</div> -->
									<div class="kt-portlet kt-portlet--mobile">
										<div class="kt-portlet__head kt-portlet__head--lg">
											<div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="kt-font-brand flaticon2-line-chart"></i>
												</span>
												<h3 class="kt-portlet__head-title">
													User's Payments
												</h3>
											</div>
											
										</div>
										<div class="kt-portlet__body">

											<!--begin: Search Form -->
											<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
												<div class="row align-items-center">
													<div class="col-xl-8 order-2 order-xl-1">
														<div class="row align-items-center">
															<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
																<div class="kt-input-icon kt-input-icon--left">
																	<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
																	<span class="kt-input-icon__icon kt-input-icon__icon--left">
																		<span><i class="la la-search"></i></span>
																	</span>
																</div>
															</div>
															
														</div>
													</div>
													<div class="col-xl-4 order-1 order-xl-2 kt-align-right">
														<a href="#" class="btn btn-default kt-hidden">
															<i class="la la-cart-plus"></i> New Order
														</a>
														<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
													</div>
												</div>
											</div>

											<!--end: Search Form -->
										</div>
										<div class="kt-portlet__body kt-portlet__body--fit">
											
											<!--begin: Datatable -->
											<div class="kt-datatable" id="load_payments"></div>
											<!--end: Datatable -->

											<!--begin::Confirm Payment Modal-->
											<div class="modal fade" id="kt_modal_fetch_payment_id_to_update_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<form>
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Confirm/Cancell Payment</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="kt-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="200">
																	<h6 id="delete-msg" style="color: red">What do you want to do?</h6>
																	<ul class="kt-datatable_selected_ids"></ul>
																</div>
															</div>
															<input type="hidden" name="transaction_id" class="transaction_id">
															<input type="hidden" name="admin_username" class="admin_username">
															<input type="hidden" name="payment_id" id="payment_id">
															<div class="modal-footer">
																<button type="button" class="btn btn-success" id="kt_datatable_confirm_payment">Confirm Payment</button>
																<button type="button" class="btn btn-warning" id="kt_datatable_cancell_payment">Cancell Payment</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
													
											</div>
											<!--end::Confirm Payment Modal-->
										</div>
									</div>
									
								</div>

								<!-- end:: Content -->
							</div>
						</div>
					</div>

					<!-- begin:: Footer -->
					<?php require_once ("../footer.php"); ?>
					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<?php require_once ("../footer-js.php"); ?>

		<!--end::Global Theme Bundle -->
		<script type="text/javascript">
			var p = getUrlParams(),
				user_id = 0;
		</script>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/payments/payments.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>