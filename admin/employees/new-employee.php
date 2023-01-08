<?php
require_once '../config.php';

$pageName = "new-employee";
$header = "employees";
$main_page = "new-employee";

?>

<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>New Employee | <?php echo $site_title; ?></title>
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
												Employees </h3>
											<span class="kt-subheader__separator kt-hidden"></span>
											<div class="kt-subheader__breadcrumbs">
												<a href="employees/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
												<span class="kt-subheader__breadcrumbs-separator"></span>
												<a href="employees/new-employee" class="kt-subheader__breadcrumbs-link">
													New Employee </a>
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
																			Setup employee basic information
																		</div>
																	</div>
																</div>
															</div>
															<div class="kt-wizard-v2__nav-item" data-ktwizard-type="step" id="step2">
																<div class="kt-wizard-v2__nav-body">
																	<div class="kt-wizard-v2__nav-icon">
																		<i class="flaticon2-phone"></i>
																	</div>
																	<div class="kt-wizard-v2__nav-label">
																		<div class="kt-wizard-v2__nav-label-title">
																			Contact Information
																		</div>
																		<div class="kt-wizard-v2__nav-label-desc">
																			Setup your contact information
																		</div>
																	</div>
																</div>
															</div>
															<div class="kt-wizard-v2__nav-item" href="#" data-ktwizard-type="step" id="step3">
																<div class="kt-wizard-v2__nav-body">
																	<div class="kt-wizard-v2__nav-icon">
																		<i class="flaticon-support"></i>
																	</div>
																	<div class="kt-wizard-v2__nav-label">
																		<div class="kt-wizard-v2__nav-label-title">
																			Next of Kin Contact
																		</div>
																		<div class="kt-wizard-v2__nav-label-desc">
																			Setup next of kin information
																		</div>
																	</div>
																</div>
															</div>
															<div class="kt-wizard-v2__nav-item" href="#" data-ktwizard-type="step" id="step4">
																<div class="kt-wizard-v2__nav-body">
																	<div class="kt-wizard-v2__nav-icon">
																		<i class="flaticon-business"></i>
																	</div>
																	<div class="kt-wizard-v2__nav-label">
																		<div class="kt-wizard-v2__nav-label-title">
																			Other Info
																		</div>
																		<div class="kt-wizard-v2__nav-label-desc">
																			Setup department, date joined, etc
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
															<div class="kt-heading kt-heading--md">Enter Employee Personal Details</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v2__form">
																	<input type="hidden" name="transaction_id" class="transaction_id">
																	<input type="hidden" name="imageDestination" id="imageDestination">
																	<div class="form-group row">
																		<label class="col-xl-3 col-lg-3 col-form-label">Profile Image</label>
																		<div class="col-lg-9 col-xl-6">
																			<div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
																				<div class="kt-avatar__holder" style="background-image: url(assets/media/users/default.jpg)"></div>
																				<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
																					<i class="fa fa-pen"></i>
																					<input type="file" name="profile_image">
																				</label>
																				<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
																					<i class="fa fa-times"></i>
																				</span>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Title</label>
																				<input type="text" class="form-control" name="title" id="title" placeholder="Title">
																			</div>
																		</div>
																		<div class="col-md-5">
																			<div class="form-group">
																				<label>Firstname</label>
																				<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
																				<span class="form-text text-muted">Please enter firstname.</span>
																			</div>
																		</div>
																		<div class="col-md-5">
																			<div class="form-group">
																				<label>Lastname</label>
																				<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
																				<span class="form-text text-muted">Please enter lastname.</span>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Gender</label>
																				<select name="gender" class="form-control" id="gender">
																					<option value="">select gender</option>
																					<option value="female">Female</option>
																					<option value="male">Male</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Marital Status</label>
																				<select name="marital_status" class="form-control" id="marital_status">
																					<option value="">select marital status</option>
																					<option value="single">Single</option>
																					<option value="married">Married</option>
																					<option value="divorced">Divorced</option>
																					<option value="prefer not to say">Prefer not to say</option>
																				</select>
																			</div>
																		</div>
																	</div>
																			
																	<div class="row">
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Place of Birth</label>
																				<input type="text" class="form-control" name="place_of_birth" placeholder="Place of Birth" id="place_of_birth">
																				<span class="form-text text-muted">Please enter your place of birth.</span>
																			</div>
																		</div>
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Date of Birth</label>
																				<input type="text" class="form-control" id="dob" readonly="" placeholder="Select date of birth" name="dob">
																				<span class="form-text text-muted">Please enter your date of birth.</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--end: Form Wizard Step 1-->

														<!--begin: Form Wizard Step 2-->
														<div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
															<div class="kt-heading kt-heading--md">Setup Contact Information</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v4__form">
																	<div class="form-group">
																		<label>Phone No 1</label>
																		<input type="tel" class="form-control" name="phone1" id="phone" placeholder="enter phone no">
																		<span class="form-text text-muted">Please enter your phone number.</span>
																	</div>
																	<div class="form-group">
																		<label>Phone No 2</label>
																		<input type="tel" class="form-control" name="phone2" id="phone" placeholder="enter alternative phone no">
																		<span class="form-text text-muted">Please enter alternative phone number.</span>
																	</div>
																	<div class="form-group">
																		<label>Email</label>
																		<input type="email" class="form-control" name="email" placeholder="Email" id="email">
																		<span class="form-text text-muted">Please enter your email address.</span>
																	</div>
																	<div class="form-group">
																		<label>Contact Address 1</label>
																		<input type="text" class="form-control" name="address1" placeholder="Enter contact address" id="address">
																		<span class="form-text text-muted">Please enter your Address.</span>
																	</div>
																	<div class="form-group">
																		<label>Contact Address 2</label>
																		<input type="text" class="form-control" name="address2" placeholder="Enter contact address" id="address">
																		<span class="form-text text-muted">Please enter alternative Address.</span>
																	</div>
																	<div class="row">
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Postcode</label>
																				<input type="text" class="form-control" name="post_code" placeholder="Postcode" id="post_code">
																				<span class="form-text text-muted">Please enter your Postcode.</span>
																			</div>
																		</div>
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>City</label>
																				<input type="text" class="form-control" name="city" placeholder="City" id="city">
																				<span class="form-text text-muted">Please enter your City.</span>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>State</label>
																				<select name="state1" id="state1" class="form-control" onchange="getLGAs();">
																				</select>
																				<span class="form-text text-muted">Please select your state.</span>
																			</div>
																		</div>
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>LGA</label>
																				<select name="lga" id="lga" class="form-control">
																					<option value="">select LGA</option>
																				</select>
																				<span class="form-text text-muted">Please select your LGA.</span>
																			</div>
																		</div>
																		<div class="col-xl-12">
																			<div class="form-group">
																				<label>Country:</label>
																				<select name="country" class="form-control" id="country">
																				</select>
																				<span class="form-text text-muted">Please select your country.</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--end: Form Wizard Step 2-->

														<!--begin: Form Wizard Step 3-->
														<div class="kt-wizard-v2__content" data-ktwizard-type="step-content">
															<div class="kt-heading kt-heading--md">Enter Next of Kin information</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v4__form">
																	<div class="form-group">
																		<label>Name</label>
																		<input type="text" class="form-control" name="contact_name" placeholder="Name" id="contact_name">
																		<span class="form-text text-muted">Please enter your next of kin name.</span>
																	</div>
																	<div class="row">
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Phone Number</label>
																				<input type="text" class="form-control" name="contact_phone" placeholder="Phone Number" id="contact_phone">
																				<span class="form-text text-muted">Please enter your next of kin phone number.</span>
																			</div>
																		</div>
																		<div class="col-xl-6">
																			<div class="form-group">
																				<label>Email</label>
																				<input type="email" class="form-control" name="contact_email" placeholder="Email" id="contact_email">
																				<span class="form-text text-muted">Please enter your next of kin email.</span>
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<label>Address</label>
																		<input type="text" class="form-control" name="contact_address" placeholder="Address" id="contact_address">
																		<span class="form-text text-muted">Please enter your next of kin address.</span>
																	</div>
																	<div class="form-group">
																		<label>Relationship</label>
																		<input type="text" class="form-control" name="contact_relationship" placeholder="Relationship" id="contact_relationship">
																		<span class="form-text text-muted">Please enter your next of kin relationship.</span>
																	</div>
																</div>
															</div> 
														</div>
														<!--end: Form Wizard Step 3-->

														<!--begin: Form Wizard Step 4-->
														<div class="kt-wizard-v2__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
															<div class="kt-heading kt-heading--md">Enter Other Info</div>
															<div class="kt-form__section kt-form__section--first">
																<div class="kt-wizard-v2__form">
																	<!-- <div class="form-group">
																		<label>Department</label>
																		<select class="form-control" name="department" id="department">
																		</select>
																		<span class="form-text text-muted">Please enter department.</span>
																	</div> -->
																	<div class="form-group">
																		<label>Date Registered</label>
																		<input type="text" class="form-control" id="joined_date" readonly="" placeholder="Select date joined" name="joined_date">
																		<span class="form-text text-muted">Please enter date joined.</span>
																	</div>
																	<div class="form-group">
																		<label>Bank Name</label>
																		<input type="text" class="form-control" name="bank_name" placeholder="Bank Name" id="bank_name">
																		<span class="form-text text-muted">Please enter your bank name.</span>
																	</div>
																	<div class="form-group">
																		<label>Acc Name</label>
																		<input type="text" class="form-control" name="acc_name" placeholder="Acc Name" id="acc_name">
																		<span class="form-text text-muted">Please enter your acc name.</span>
																	</div>
																	<div class="form-group">
																		<label>Acc No</label>
																		<input type="text" class="form-control" name="acc_no" placeholder="Acc No" id="acc_no">
																		<span class="form-text text-muted">Please enter your acc no.</span>
																	</div>
																	<div class="form-group">
																		<label>Bank Sort Code</label>
																		<input type="text" class="form-control" name="bank_sort_code" placeholder="Bank Sort Code" id="bank_sort_code">
																		<span class="form-text text-muted">Please enter your bank sort code.</span>
																	</div>
																</div>
															</div>
														</div>
														<!--end: Form Wizard Step 4-->

														<!--begin: Form Actions -->
														<div class="kt-form__actions">
															<button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
																Previous
															</button>
															<button class="btn btn-info btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
																Submit
															</button>
															<button class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next" id="next_step">
																Next Step
															</button>
														</div>
														
															<input type="hidden" name="employee_id" class="employee_id">
															<input type="hidden" name="user_ses_id" class="user_ses_id">
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
		<script src="assets/js/pages/custom/employees/new-employee.js?p=1" type="text/javascript"></script>
		<script src="assets/js/pages/custom/users/profile.js" type="text/javascript"></script>

		<script src="assets/js/pages/custom/general/get-states.js" type="text/javascript"></script>
		<script src="assets/js/pages/custom/general/get-countries.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>