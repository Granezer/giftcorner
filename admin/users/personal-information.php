<?php
require_once '../config.php';
$header = "user-personal-information";
$pageName = "user-personal-information";

require_once 'user-details.php';

?>

<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>User Personal Information | <?php echo $site_title; ?></title>
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
											<button class="kt-subheader__mobile-toggle" id="kt_subheader_mobile_toggle"><span></span></button>
											<h3 class="kt-subheader__title">Personal Information</h3>
										</div>
									</div>
								</div>

								<!-- end:: Content Head -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">

									<!--Begin::App-->
									<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

										<!--Begin:: App Aside Mobile Toggle-->
										<?php require_once ("user-profile-aside.php"); ?>
										<!--End:: App Aside-->

										<!--Begin:: App Content-->
										<div class="kt-grid__item kt-grid__item--fluid kt-app__content">
											<div class="row">
												<div class="col-xl-12">
													<div class="kt-portlet">
														<div class="kt-portlet__head">
															<div class="kt-portlet__head-label">
																<h3 class="kt-portlet__head-title">Personal Information <small><?php echo $response['fullname'] ?> personal informaiton</small></h3>
															</div>
														</div>
														<form class="kt-form kt-form--label-right">
															<div class="kt-portlet__body">
																<div class="kt-section kt-section--first">
																	<div class="kt-section__body">
																		<div class="row">
																			<label class="col-xl-3"></label>
																			<div class="col-lg-9 col-xl-6">
																				<h3 class="kt-section__title kt-section__title-sm">User Info:</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Profile Image</label>
																			<div class="col-lg-9 col-xl-6">
																				<div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
																					<div class="kt-avatar__holder" style="background-image: url(<?php echo $response['profile_image_url'];?>)"></div>
																				</div>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Name</label>
																			<div class="col-lg-9 col-xl-6">
																				<input class="form-control" type="text" value="<?php echo $response['fullname']; ?>">
																			</div>
																		</div>

																		<div class="row">
																			<label class="col-xl-3"></label>
																			<div class="col-lg-9 col-xl-6">
																				<h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
																			<div class="col-lg-9 col-xl-6">
																				<div class="input-group">
																					<div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
																					<input type="text" class="form-control" value="<?php echo $response['phone']; ?>" placeholder="Phone" aria-describedby="basic-addon1">
																				</div>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
																			<div class="col-lg-9 col-xl-6">
																				<div class="input-group">
																					<div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
																					<input type="text" class="form-control" value="<?php echo $response['email']; ?>" placeholder="Email" aria-describedby="basic-addon1">
																				</div>
																			</div>
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
					<?php require_once ("../footer.php"); ?>
					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<?php require_once ("../footer-js.php"); ?>

		<!--end::Global Theme Bundle -->

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>