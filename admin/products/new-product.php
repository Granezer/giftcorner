<?php
require_once '../config.php';

$pageName = "new-product";
$header = "products";
$page_title = "New Product";
$main_page = "new-product";
$product_id = $template = 0;

$module_name = "products";
$module_permission_name = "create";
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page == "edit-product.php") {
	$page_title = "Edit Product";
	$product_id = isset($_GET['id']) ? $_GET['id'] : 0;
	$module_permission_name = "write";
} else $template = isset($_GET['template']) ? $_GET['template'] : 0;
?>

<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title><?php echo $page_title;?> | <?php echo $site_title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!--begin::Page Custom Styles(used by this page) -->
		<link href="assets/css/pages/wizard/wizard-2.css" rel="stylesheet" type="text/css" />

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

								<!-- begin:: Subheader -->
								<div class="kt-subheader   kt-grid__item" id="kt_subheader">
									<div class="kt-container  kt-container--fluid ">
										<div class="kt-subheader__main">
											<h3 class="kt-subheader__title">
												Products </h3>
											<span class="kt-subheader__separator kt-hidden"></span>
											<div class="kt-subheader__breadcrumbs">
												<a href="products/products" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
												<span class="kt-subheader__breadcrumbs-separator"></span>
												<a href="products/new-product" class="kt-subheader__breadcrumbs-link">
													New Product </a>
											</div>
										</div>
									</div>
								</div>

								<!-- end:: Subheader -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
									<div class="kt-portlet">
										<div class="kt-portlet__body kt-portlet__body--fit">
											<div class="kt-grid  kt-wizard-v2 kt-wizard-v2--white" id="kt_wizard_v2" data-ktwizard-state="step-first">
												<div class="kt-grid__item kt-wizard-v2__aside">

													<!--begin: Form Wizard Nav -->
													<div class="kt-wizard-v2__nav">
														<div class="kt-wizard-v2__nav-items">

															<!--doc: Replace A tag with SPAN tag to disable the step link click -->
															<div class="kt-wizard-v2__nav-item" data-ktwizard-type="step" data-ktwizard-state="current" id="step1">
																<div class="kt-wizard-v2__nav-body">
																	<div class="kt-wizard-v2__nav-icon">
																		<i class="flaticon-user-add"></i>
																	</div>
																	<div class="kt-wizard-v2__nav-label">
																		<div class="kt-wizard-v2__nav-label-title">
																			Basic Information
																		</div>
																		<div class="kt-wizard-v2__nav-label-desc">
																			merchant name, product name, price, description, and images
																		</div>
																	</div>
																</div>
															</div>
															<div class="kt-wizard-v2__nav-item" href="#" data-ktwizard-type="step" id="step2">
																<div class="kt-wizard-v2__nav-body">
																	<div class="kt-wizard-v2__nav-icon">
																		<i class="flaticon-support"></i>
																	</div>
																	<div class="kt-wizard-v2__nav-label">
																		<div class="kt-wizard-v2__nav-label-title">
																			Discounts and Weight
																		</div>
																		<div class="kt-wizard-v2__nav-label-desc">
																			Setup discount and weight
																		</div>
																	</div>
																</div>
															</div>
															<div class="kt-wizard-v2__nav-item" href="#" data-ktwizard-type="step" id="step3">
																<div class="kt-wizard-v2__nav-body">
																	<div class="kt-wizard-v2__nav-icon">
																		<i class="flaticon-business"></i>
																	</div>
																	<div class="kt-wizard-v2__nav-label">
																		<div class="kt-wizard-v2__nav-label-title">
																			Image
																		</div>
																		<div class="kt-wizard-v2__nav-label-desc">
																			Upload product images
																		</div>
																	</div>
																</div>
															</div>
															
														</div>
													</div>

													<!--end: Form Wizard Nav -->
												</div>
												<div class="kt-grid__item kt-grid__item--fluid kt-wizard-v2__wrapper">

													<!--begin: Form Wizard Form-->
													<form class="kt-form" id="kt_form">

														<!--begin: Form Wizard Step 1-->
														<div class="kt-wizard-v2__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
															<div class="kt-heading kt-heading--md">Enter Product Details</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v2__form">
																	<input type="hidden" name="transaction_id" class="transaction_id">
																	<input type="hidden" name="id" id="id" value="<?php echo $product_id;?>">
																	<input type="hidden" id="template" value="<?php echo $template;?>">
																	<div class="form-group">
																		<label>Product Name</label>
																		<input type="text" class="form-control" name="name" placeholder="product Name" id="name">
																		<span class="form-text text-muted">Please enter product name.</span>
																	</div>
																			
																	<div class="row">
																		<div class="col-xl-12">
																			<div class="form-group">
																				<label>Selling Price</label>
																				<input type="text" class="form-control" id="price" placeholder="Product selling price" name="price" onkeypress="return numbers(event,this.id)">
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xl-12">
																			<div class="form-group">
																				<label>Short Description</label>
																				<textarea class="form-control" id="short_desc" placeholder="Product Short Description" name="short_desc" rows="3"></textarea>
																				<span class="form-text text-muted">Please enter product short description.</span>
																			</div>
																		</div>
																		<div class="col-xl-12">
																			<div class="form-group">
																				<label>Description</label>
																				<textarea class="form-control" id="description" placeholder="Product Description" name="description" rows="7"></textarea>
																				<span class="form-text text-muted">Please enter product description.</span>
																			</div>
																		</div>
																	</div>

																</div>
															</div>
														</div>
														<!--end: Form Wizard Step 1-->

														<!--begin: Form Wizard Step 2-->
														<div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
															<div class="kt-heading kt-heading--md">Enter Product information</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v4__form">
																			
																	<div class="row">
																		<div class="col-xl-4">
																			<div class="form-group">
																				<label>Discount (%)</label>
																				<input type="text" class="form-control" name="product_off" placeholder="e.g 5" id="product_off" onkeypress="return numbers(event,this.id)">
																			</div>
																		</div>
																		<div class="col-xl-4">
																			<div class="form-group">
																				<label>Discount Start Date</label>
																				<input type="text" class="form-control discount_start_date" name="discount_start_date" placeholder="Enter date" id="discount_start_date" readonly="">
																			</div>
																		</div>
																		<div class="col-xl-4">
																			<div class="form-group">
																				<label>Discount End Date</label>
																				<input type="text" class="form-control discount_end_date" name="discount_end_date" placeholder="Enter date" id="discount_end_date" readonly="">
																			</div>
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xl-3">
																			<div class="form-group">
																				<label>Weight</label>
																				<input type="text" class="form-control" name="weight" placeholder="e.g 1" id="weight" onkeypress="return numbers(event,this.id)">
																			</div>
																		</div>
																		<div class="col-xl-3">
																			<div class="form-group">
																				<label>Breadth</label>
																				<input type="text" class="form-control" name="breadth" placeholder="e.g 10" id="breadth" onkeypress="return numbers(event,this.id)">
																			</div>
																		</div>
																		<div class="col-xl-3">
																			<div class="form-group">
																				<label>Length</label>
																				<input type="text" class="form-control" name="length" placeholder="e.g 8" id="length" onkeypress="return numbers(event,this.id)">
																			</div>
																		</div>
																		<div class="col-xl-3">
																			<div class="form-group">
																				<label>Depth</label>
																				<input type="text" class="form-control" name="depth" placeholder="e.g 12" id="depth" onkeypress="return numbers(event,this.id)">
																			</div>
																		</div>
																	</div>
																	
																</div>
															</div> 
														</div>
														<!--end: Form Wizard Step 2-->

														<!--begin: Form Wizard Step 3-->
														<div class="kt-wizard-v2__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
															<div class="kt-heading kt-heading--md">Product Images</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v2__form">
																	
																	<div class="kt-section__content" style="display: block;" id="images">

																	</div>	
																	
																	<div class="form-group row">
																		<div class="dropzone dropzone-default dropzone-brand dz-clickable col-xl-12" id="kt_dropzone_3">
																			<div class="dropzone-msg dz-message needsclick">
																				<h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
																				<span class="dropzone-msg-desc">Upload up to 10 files</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--end: Form Wizard Step 3-->

														<!--begin: Form Actions -->
														<div class="kt-form__actions">
															<button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
																Previous
															</button>
															<button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
																Submit
															</button>
															<button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next" id="next_step">
																Next Step
															</button>
														</div>

														<!--end: Form Actions -->
													</form>

													<!--end: Form Wizard Form-->
												</div>
											</div>
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

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<?php require_once ("../footer-js.php"); ?>

		<!--begin::Page Scripts(used by this page) -->
		<!-- <script src="assets/js/pages/custom/products/product-images.js" type="text/javascript"></script> -->

		<script src="assets/js/pages/crud/file-upload/dropzonejs.js" type="text/javascript"></script>
		<!--end::Page Scripts -->

		<?php
		if ($product_id) {
		?>
			<!--begin::Page Scripts(used by this page) -->
			<script src="assets/js/pages/custom/products/edit-product.js" type="text/javascript"></script>
			<script src="assets/js/pages/custom/products/get-product.js?p=0" type="text/javascript"></script>
		<?php
		} else {
		?>
			<?php
			if ($template) {
			?>
				<script src="assets/js/pages/custom/products/get-product-template.js" type="text/javascript"></script>
			<?php
			}
			?>
			<!--begin::Page Scripts(used by this page) -->
			<script src="assets/js/pages/custom/products/new-product.js" type="text/javascript"></script>
		<?php
		}
		?>
	</body>

	<!-- end::Body -->
</html>