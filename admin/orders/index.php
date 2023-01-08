<?php
require_once '../config.php';
$header = "orders";
$pageName = "All Orders";
$status = isset($_GET['status']) ? $_GET['status'] : "";
if ($status) {
	switch ($status) {
		case 'delivered':
			$pageName = "Delivered Orders";
			break;
		case 'awaiting payment':
			$pageName = "Awaiting Payment Orders";
			break;
		case 'pending':
			$pageName = "Pending Orders";
			break;
		case 'pending pickup':
			$pageName = "Pending Pickup Orders";
			break;
		case 'pending delivery':
			$pageName = "Pending Delivery Orders";
			break;
		case 'cancelled':
			$pageName = "Cancelled Orders";
			break;
		default:
			$pageName = "All Orders";
			break;
	}
}
?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title><?php echo $pageName; ?> | <?php echo $site_title; ?></title>
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
											<h3 class="kt-subheader__title"><?php echo $pageName; ?></h3>
											
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
													<?php echo $pageName; ?>
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
												</div>
											</div>

											<!--end: Search Form -->

											<!--begin: Selected Rows Group Action Form -->
											<div class="kt-form kt-form--label-align-right kt-margin-t-20 collapse" id="kt_datatable_group_action_form">
												<div class="row align-items-center">
													<div class="col-xl-12">
														<div class="kt-form__group kt-form__group--inline">
															<div class="kt-form__label kt-form__label-no-wrap">
																<label class="kt-font-bold kt-font-danger-">Selected
																	<span id="kt_datatable_selected_number">0</span> records:</label>
															</div>
															<div class="kt-form__control">
																<div class="btn-toolbar">
																	<div class="dropdown">
																		<button type="button" class="btn btn-brand btn-sm dropdown-toggle" data-toggle="dropdown">
																			Update status
																		</button>
																		<div class="dropdown-menu">
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_order_id_to_update" onclick="updateStatus('Accepted')">Confirm</a>
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_order_id_to_update" onclick="updateStatus('Pending Pickup')">Pending Pickup</a>
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_order_id_to_update" onclick="updateStatus('Pending Delivery')">Pending Delivery</a>
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_order_id_to_update" onclick="updateStatus('Cancelled')">Cancel</a>
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_order_id_to_update" onclick="updateStatus('Delivered')">Delivered</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--end: Selected Rows Group Action Form -->
										</div>
										<div class="kt-portlet__body kt-portlet__body--fit">

											<!--begin: Datatable -->
											<div class="kt-datatable" id="load_orders"></div>
											<!--end: Datatable -->

											<!--begin::Update Status Modal-->
											<div class="modal fade" id="kt_modal_fetch_order_id_to_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
												<form>
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel1">Update Product Product</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="kt-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="200">
																	<h6 id="update-msg" style="color: red">Are you sure you want to update the status of the below listed order id(s)?</h6>
																	<ul class="kt-datatable_selected_order_ids"></ul>

																	<!-- <div class="col-md-12">
																		<div class="form-group">
																			<label>Description</label>
																			<textarea class="form-control" name="description"></textarea>
																		</div>
																	</div> -->
																</div>
															</div>
															<input type="hidden" name="transaction_id" class="transaction_id">
															<input type="hidden" name="employee_id" class="employee_id">
															<input type="hidden" name="user_ses_id" class="user_ses_id">
															<input type="hidden" name="ids" id="ids">
															<input type="hidden" name="status" id="order_status">
															<div class="modal-footer">
																<button type="button" class="btn btn-danger" id="kt_datatable_update_orders_status">Update</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
													
											</div>
											<!--end::Update Status Modal-->

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
				order_status = p.hasOwnProperty("status") 
					? p['status'].toLowerCase() : 100;

			if (order_status == "pending")
				order_status = 1;
			else if (order_status == "awaiting payment")
				order_status = 10;
			else if (order_status == "pending pickup")
				order_status = 11;
			else if (order_status == "pending delivery")
				order_status = 5;
			else if (order_status == "delivered")
				order_status = 6;
			else if (order_status == "cancelled")
				order_status = 3;

			function updateStatus(status) {
				// $("#update-msg").html("Are you sure you want to update the status of the below listed loan id(s)? to " + status.toUpperCase());
				// status = status.toLowerCase();
				$("#order_status").val(status);
			}
		</script>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/orders/orders.js" type="text/javascript"></script>
		<script src="assets/js/pages/custom/orders/update-order-status.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>