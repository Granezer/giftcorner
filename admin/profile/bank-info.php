<?php
require_once '../config.php';
require_once 'index.php';

$pageName = "bank-info";
$header = "profile";
$main_page = "bank";
?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>Bank Information | <?php echo $site_title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<?php require_once ("../head-css.php"); ?>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<?php require_once("../header-mobile.php");?>
		<!-- end:: Header Mobile -->

		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<?php require_once("../header.php");?>
					<!-- end:: Header -->

					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
						<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">

							<!-- begin:: Aside -->
							<?php require_once("../header-aside.php");?>
							<!-- end:: Aside -->

							
							<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

								<!-- begin:: Subheader -->
								<div class="kt-subheader   kt-grid__item" id="kt_subheader">
									<div class="kt-container ">
										<div class="kt-subheader__main">
											<h3 class="kt-subheader__title">
												<button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
												Employee Profile  </h3>
											<span class="kt-subheader__separator kt-hidden"></span>
											<div class="kt-subheader__breadcrumbs">
												<a href="employees/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
												<span class="kt-subheader__breadcrumbs-separator"></span>
												<a href="profile/bank-info?id=<?php echo $id;?>" class="kt-subheader__breadcrumbs-link">
													Bank Information </a>
											</div>
										</div>
									</div>
								</div>

								<!-- end:: Subheader -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">

									<!--Begin::App-->
									<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

										<!--Begin:: App Aside Mobile Toggle-->
										<button class="kt-app__aside-close" id="kt_user_profile_aside_close">
											<i class="la la-close"></i>
										</button>

										<!--End:: App Aside Mobile Toggle-->

										<!--Begin:: App Aside-->
										<?php require_once("profile-aside.php");?>

										<!--End:: App Aside-->

										<!--Begin:: App Content-->
										<div class="kt-grid__item kt-grid__item--fluid kt-app__content">
											<div class="row">
												<div class="col-xl-12">
													<div class="kt-portlet">
														<div class="kt-portlet__head">
															<div class="kt-portlet__head-label">
																<h3 class="kt-portlet__head-title">Bank Information <small>update bank informaiton</small></h3>
															</div>
															
														</div>
														<form class="kt-form kt-form--label-right">
															<div class="kt-portlet__body">
																<div class="kt-section kt-section--first">
																	<div class="kt-section__body">
																		<div class="row">
																			<label class="col-xl-3"></label>
																			<div class="col-lg-9 col-xl-6">
																				<h3 class="kt-section__title kt-section__title-sm">Bank Info:</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Name</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" name="bank_name" value="<?php echo $employee->bank_name; ?>">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Account Name</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" value="<?php echo $employee->acc_name; ?>" name="acc_name" >
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Account No.</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" value="<?php echo $employee->acc_no; ?>" name="acc_no" >
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Sort Code</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" value="<?php echo $employee->bank_sort_code; ?>" name="bank_sort_code" >
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="kt-portlet__foot">
																<div class="kt-form__actions">
																	<div class="row">
																		<div class="col-lg-3 col-xl-3">
																			<input type="hidden" name="transaction_id" class="transaction_id">
																			<input type="hidden" name="employee_id" class="employee_id">
																			<input type="hidden" name="user_ses_id" class="user_ses_id">
																			<input type="hidden" name="id" value="<?php echo $employee->id; ?>">
																		</div>
																		<div class="col-lg-9 col-xl-9">
																			<button type="button" class="btn btn-danger" id="update_employee_bank_info_submit">Update</button>&nbsp;
																			<button type="reset" class="btn btn-secondary">Cancel</button>
																		</div>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>

										<!--End:: App Content-->
									</div>

									<!--End::App-->
								</div>

								<!-- end:: Content -->
							</div>
						</div>
					</div>

					<!-- begin:: Footer -->
					<?php require_once("../footer.php");?>
					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->


		<?php require_once("../footer-js.php");?>
		<script src="assets/js/pages/custom/users/profile.js" type="text/javascript"></script>
		<script src="assets/js/pages/custom/employees/update-employee.js?p=1" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>