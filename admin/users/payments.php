<?php
require_once '../config.php';
$header = "user-payments";
$pageName = "user-payments";

require_once 'user-details.php';

?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>User Payments | <?php echo $site_title; ?></title>
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
											<h3 class="kt-subheader__title">Payments</h3>
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
													<div class="kt-portlet kt-portlet--height-fluid">
														
														<!--begin: Datatable -->
														<div class="kt-datatable" id="load_payments"></div>
														<!--end: Datatable -->

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

		<!-- end::Global Config -->
		<?php require_once ("../footer-js.php"); ?>

		<!--end::Global Theme Bundle -->
		<script type="text/javascript">
			var p = getUrlParams(),
				user_id = p.hasOwnProperty("user_id") ? p['user_id'] : 0;


		</script>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/payments/payments.js" type="text/javascript"></script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>