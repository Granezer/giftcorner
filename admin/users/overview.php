<?php
require_once '../config.php';

$header = "user-profile-overview";
$pageName = "user-profile-overview";

require_once 'user-details.php';

header("Location: personal-information?user_id=".$response['id']);
exit;

?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>User Profile Overview | <?php echo $site_title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<?php require_once ("../head-css.php"); ?>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-app__aside--left kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

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
											<h3 class="kt-subheader__title">User Profile</h3>
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
												<div class="col-xl-6">

													<!--begin:: Widgets/Order Statistics-->
													<div class="kt-portlet kt-portlet--height-fluid">
														<div class="kt-portlet__head">
															<div class="kt-portlet__head-label">
																<h3 class="kt-portlet__head-title">
																	Order Statistics
																</h3>
															</div>
														</div>
														<div class="kt-portlet__body kt-portlet__body--fluid">
															<div class="kt-widget12">
																<div class="kt-widget12__content">
																	<div class="kt-widget12__item">
																		<div class="kt-widget12__info">
																			<span class="kt-widget12__desc">Annual Taxes EMS</span>
																			<span class="kt-widget12__value">$400,000</span>
																		</div>
																		<div class="kt-widget12__info">
																			<span class="kt-widget12__desc">Finance Review Date</span>
																			<span class="kt-widget12__value">July 24,2019</span>
																		</div>
																	</div>
																	<div class="kt-widget12__item">
																		<div class="kt-widget12__info">
																			<span class="kt-widget12__desc">Avarage Revenue</span>
																			<span class="kt-widget12__value">$60M</span>
																		</div>
																		<div class="kt-widget12__info">
																			<span class="kt-widget12__desc">Revenue Margin</span>
																			<div class="kt-widget12__progress">
																				<div class="progress kt-progress--sm">
																					<div class="progress-bar kt-bg-brand" role="progressbar" style="width: 40%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																				<span class="kt-widget12__stat">
																					40%
																				</span>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="kt-widget12__chart" style="height:250px;">
																	<canvas id="kt_chart_order_statistics"></canvas>
																</div>
															</div>
														</div>
													</div>

													<!--end:: Widgets/Order Statistics-->
												</div>
												<div class="col-xl-6">

													<!--begin:: Widgets/Tasks -->
													<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
														<div class="kt-portlet__head">
															<div class="kt-portlet__head-label">
																<h3 class="kt-portlet__head-title">
																	Recent Activities
																</h3>
															</div>
															
														</div>
														<div class="kt-portlet__body">
															<div class="tab-content">
																<div class="tab-pane active" id="kt_widget2_tab1_content">
																	<div class="kt-widget2">
																		<div class="kt-widget2__item kt-widget2__item--warning">
																			<div class="kt-widget2__checkbox">
																				
																			</div>
																			<div class="kt-widget2__info">
																				<a href="#" class="kt-widget2__title">
																					Prepare Docs For Metting On Monday
																				</a>
																				<a href="#" class="kt-widget2__username">
																					By Sean
																				</a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<!--end:: Widgets/Tasks -->
												</div>
											</div>
											<div class="row">
												<div class="col-xl-12">

													<!--begin:: Widgets/Notifications-->
													<div class="kt-portlet kt-portlet--height-fluid">
														<div class="kt-portlet__head">
															<div class="kt-portlet__head-label">
																<h3 class="kt-portlet__head-title">
																	Recent Notifications
																</h3>
															</div>
														</div>
														<div class="kt-portlet__body">
															<div class="tab-content">
																<div class="tab-pane active" id="kt_widget6_tab1_content" aria-expanded="true">
																	<div class="kt-notification">
																		<a href="#" class="kt-notification__item">
																			<div class="kt-notification__item-icon">
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
																						<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
																					</g>
																				</svg> </div>
																			<div class="kt-notification__item-details">
																				<div class="kt-notification__item-title">
																					New order has been received.
																				</div>
																				<div class="kt-notification__item-time">
																					2 hrs ago
																				</div>
																			</div>
																		</a>
																		<a href="#" class="kt-notification__item">
																			<div class="kt-notification__item-icon">
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<path d="M12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.98630124,11 4.48466491,11.0516454 4,11.1500272 L4,7 C4,5.8954305 4.8954305,5 6,5 L20,5 C21.1045695,5 22,5.8954305 22,7 L22,16 C22,17.1045695 21.1045695,18 20,18 L12.9835977,18 Z M19.1444251,6.83964668 L13,10.1481833 L6.85557487,6.83964668 C6.4908718,6.6432681 6.03602525,6.77972206 5.83964668,7.14442513 C5.6432681,7.5091282 5.77972206,7.96397475 6.14442513,8.16035332 L12.6444251,11.6603533 C12.8664074,11.7798822 13.1335926,11.7798822 13.3555749,11.6603533 L19.8555749,8.16035332 C20.2202779,7.96397475 20.3567319,7.5091282 20.1603533,7.14442513 C19.9639747,6.77972206 19.5091282,6.6432681 19.1444251,6.83964668 Z" fill="#000000" />
																						<path d="M8.4472136,18.1055728 C8.94119209,18.3525621 9.14141644,18.9532351 8.89442719,19.4472136 C8.64743794,19.9411921 8.0467649,20.1414164 7.5527864,19.8944272 L5,18.618034 L5,14.5 C5,13.9477153 5.44771525,13.5 6,13.5 C6.55228475,13.5 7,13.9477153 7,14.5 L7,17.381966 L8.4472136,18.1055728 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																					</g>
																				</svg> </div>
																			<div class="kt-notification__item-details">
																				<div class="kt-notification__item-title">
																					New member is registered and pending for approval.
																				</div>
																				<div class="kt-notification__item-time">
																					3 hrs ago
																				</div>
																			</div>
																		</a>
																		<a href="#" class="kt-notification__item">
																			<div class="kt-notification__item-icon">
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<path d="M12,10.9996338 C12.8356605,10.3719448 13.8743941,10 15,10 C17.7614237,10 20,12.2385763 20,15 C20,17.7614237 17.7614237,20 15,20 C13.8743941,20 12.8356605,19.6280552 12,19.0003662 C11.1643395,19.6280552 10.1256059,20 9,20 C6.23857625,20 4,17.7614237 4,15 C4,12.2385763 6.23857625,10 9,10 C10.1256059,10 11.1643395,10.3719448 12,10.9996338 Z M13.3336047,12.504354 C13.757474,13.2388026 14,14.0910788 14,15 C14,15.9088933 13.7574889,16.761145 13.3336438,17.4955783 C13.8188886,17.8206693 14.3938466,18 15,18 C16.6568542,18 18,16.6568542 18,15 C18,13.3431458 16.6568542,12 15,12 C14.3930587,12 13.8175971,12.18044 13.3336047,12.504354 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																						<circle fill="#000000" cx="12" cy="9" r="5" />
																					</g>
																				</svg> </div>
																			<div class="kt-notification__item-details">
																				<div class="kt-notification__item-title">
																					Membership application has been added.
																				</div>
																				<div class="kt-notification__item-time">
																					3 hrs ago
																				</div>
																			</div>
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<!--end:: Widgets/Notifications-->
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

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>
		<script src="assets/js/pages/custom/user/profile.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>