<?php
require_once '../config.php';
$header = "products";
$pageName = "All Products";
$status = isset($_GET['status']) ? $_GET['status'] : "";
if ($status) {
	switch ($status) {
		case 'live':
			$pageName = "Live Products";
			break;
		case 'paused':
			$pageName = "Paused Products";
			break;
		default:
			$pageName = "All Products";
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
											<div class="kt-portlet__head-toolbar">
												<div class="kt-portlet__head-wrapper">
													<a href="products/new-product" class="btn btn-primary btn-icon-sm">
														New Product
													</a>
												</div>
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
															<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
																<div class="kt-form__group kt-form__group--inline">
																	<div class="kt-form__label">
																		<label>Status:</label>
																	</div>
																	<div class="kt-form__control">
																		<select class="form-control bootstrap-select" id="kt_form_status">
																			<option value="">All</option>
																			<option value="1">Live on site</option>
																			<option value="0">Paused</option>
																		</select>
																	</div>
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
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_product_id_to_update" onclick="updateStatus('Paused')">Paused</a>
																			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#kt_modal_fetch_product_id_to_update" onclick="updateStatus('live on site')">Live on site</a>
																		</div>
																	</div>
																	&nbsp;&nbsp;&nbsp;
																	<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#kt_modal_fetch_product_id_to_delete">Delete All</button>
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
											<div class="kt-datatable" id="load_products"></div>
											<!--end: Datatable -->

											<!--begin::Update Status Modal-->
											<div class="modal fade" id="kt_modal_fetch_product_id_to_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
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
																	<h6 id="update-msg" style="color: red">Are you sure you want to update the status of the below listed product id(s)?</h6>
																	<ul class="kt-datatable_selected_product_ids"></ul>
																</div>
															</div>
															<input type="hidden" name="transaction_id" class="transaction_id">
															<input type="hidden" name="employee_id" class="employee_id">
															<input type="hidden" name="user_ses_id" class="user_ses_id">
															<input type="hidden" name="ids" id="ids">
															<input type="hidden" name="status" id="product_status">
															<div class="modal-footer">
																<button type="button" class="btn btn-danger" id="kt_datatable_update_products_status">Update</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
													
											</div>
											<!--end::Update Status Modal-->

											<!--begin::Delete Modal-->
											<div class="modal fade" id="kt_modal_fetch_product_id_to_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<form>
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="kt-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="200">
																	<h6 id="delete-msg" style="color: red">Are you sure you want to delete the below listed product id(s)?</h6>
																	<ul class="kt-datatable_selected_ids"></ul>
																</div>
															</div>
															<input type="hidden" name="transaction_id" class="transaction_id">
															<input type="hidden" name="employee_id" class="employee_id">
															<input type="hidden" name="user_ses_id" class="user_ses_id">
															<input type="hidden" name="ids" id="product_ids">
															<div class="modal-footer">
																<button type="button" class="btn btn-danger" id="kt_datatable_delete_all_products">Delete</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
													
											</div>
											<!--end::Delete Modal-->

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
				store_id = 0,
				product_status = p.hasOwnProperty("status") ? p['status'] : '100';
			product_status.toLowerCase();

			if (product_status == "live")
				product_status = 1;
			else if (product_status == "paused")
				product_status = 0;
		</script>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/products/products.js?p=1" type="text/javascript"></script>
		<script src="assets/js/pages/custom/products/delete-products.js" type="text/javascript"></script>
		<script src="assets/js/pages/custom/products/update-product-status.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>
	<script type="text/javascript">
		function updateStatus(status) {
			$("#update-msg").html("Are you sure you want to update the status of the below listed product id(s)? to " + status.toUpperCase());
			status = status.toLowerCase();
			if (status == "live on site")
				status = 1;
			else if (status == "paused")
				status = 0;
			$("#product_status").val(status);
		}

		function deleteProduct(id) {
		    alert("yes");
		    $(".transaction_id").val(getTransactionId());
		    $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));
		    $("#product_ids").val(id);
		    $("#delete-msg").html("Are you sure you want to delete this product?");
		}
	</script>
	<!-- end::Body -->
</html>