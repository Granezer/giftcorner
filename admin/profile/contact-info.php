<?php
require_once '../config.php';
require_once 'index.php';

$pageName = "contact-info";
$header = "profile";
$main_page = "contact";
?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>Contact Information | <?php echo $site_title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<?php require_once ("../head-css.php"); ?>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

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
												<a href="profile/contact-info?id=<?php echo $id;?>" class="kt-subheader__breadcrumbs-link">
													Contact Information </a>
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
																<h3 class="kt-portlet__head-title">Contact Information <small>update your contact informaiton</small></h3>
															</div>
															
														</div>
														<form class="kt-form kt-form--label-right">
															<div class="kt-portlet__body">
																<div class="kt-section kt-section--first">
																	<div class="kt-section__body">
																		<div class="row">
																			<label class="col-xl-3"></label>
																			<div class="col-lg-9 col-xl-6">
																				<h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Phone Line 1</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" name="phone1" value="<?php echo $employee->phone1; ?>">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Phone Line 2</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" value="<?php echo $employee->phone2; ?>" name="phone2" >
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="email" value="<?php echo $employee->email; ?>" name="email" >
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Contact Address</label>
																			<div class="col-lg-9 col-xl-6">
																				<input type="text" class="form-control" name="address1" value="<?php echo $employee->address1; ?>">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Resident Address</label>
																			<div class="col-lg-9 col-xl-6">
																				<input type="text" class="form-control" name="address2" value="<?php echo $employee->address2; ?>">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Postcode</label>
																			<div class="col-lg-9 col-xl-6">
																				<input type="text" class="form-control" name="post_code" value="<?php echo $employee->post_code; ?>">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">City</label>
																			<div class="col-lg-9 col-xl-6">
																				<input type="text" class="form-control" name="city" value="<?php echo $employee->city; ?>">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">LGA</label>
																			<div class="col-lg-9 col-xl-6">
																				<select name="lga" id="lga" class="form-control">
																					<?php 
																					foreach ($lgas as $lga) {
																					?>
																						<option value="<?php echo $lga->id; ?>" <?php if($lga->id == $employee->lga_id) echo "selected"; ?>><?php echo $lga->name; ?></option>
																					<?php
																					}
																					?>
																				</select>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">State</label>
																			<div class="col-lg-9 col-xl-6">
																				<select name="state1" id="state" class="form-control" onchange="return getLGAs();">
																					<?php 
																					foreach ($states as $state) {
																					?>
																						<option value="<?php echo $state->id; ?>" <?php if($state->id == $employee->state_id) echo "selected"; ?>><?php echo $state->name; ?></option>
																					<?php
																					}
																					?>
																				</select>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Country</label>
																			<div class="col-lg-9 col-xl-6">
																				<select name="country" id="country" class="form-control">
																					<?php 
																					foreach ($countries as $country) {
																					?>
																						<option value="<?php echo $country->id; ?>" <?php if($country->id == $employee->country) echo "selected"; ?>><?php echo $country->name; ?></option>
																					<?php
																					}
																					?>
																				</select>
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
																			<button type="button" class="btn btn-danger" id="update_employee_contact_info_submit">Update</button>&nbsp;
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

<script type="text/javascript">
// document.getElementById("state").addEventListener("change", getLGAs);

function getLGAs() {
  var param = $("#state").val();
  var options = $("#lga");
  options.empty();
  
  param = 'state=' + param;
  $.ajax({
		type:'GET',
		url: endPoint + 'settings/get-lgas-by-state.php',
		data:param,
		dataType: 'json',
		// cache:false,
		success:function(response) {
			options.append(new Option("select LGA", ''));
			$.each(response['data'], function(i, d) {
                options.append(new Option(d.name, d.id));
            });
		},
		error: function(error) {
			console.log(error);
		}
	});

	return false;
  
}
</script>