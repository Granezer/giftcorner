<?php
require_once 'config.php';
$pageName = "logs";
$header = "logs";
?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>Tax Online Management System | Activity Logs</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<?php require_once ("head-css.php"); ?>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<?php require_once ("header-mobile.php"); ?>
		<!-- end:: Header Mobile -->

		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<?php require_once ("header.php"); ?>
					<!-- end:: Header -->

					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
						<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
							<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

								<!-- begin:: Content Head -->
								<div class="kt-subheader   kt-grid__item" id="kt_subheader">
									<div class="kt-container ">
										<div class="kt-subheader__main">
											<h3 class="kt-subheader__title">
												Activity Logs
											</h3>
											<span class="kt-subheader__separator kt-subheader__separator--v"></span>
											<div class="kt-subheader__group" id="kt_subheader_search">
												<span class="kt-subheader__desc" id="kt_subheader_total">
													0 Total </span>
												<form class="kt-margin-l-20" id="kt_subheader_search_form">
													<div class="kt-input-icon kt-input-icon--right kt-subheader__search">
														<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
														<span class="kt-input-icon__icon kt-input-icon__icon--right">
															<span>
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																		<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
																	</g>
																</svg>
															</span>
														</span>
													</div>
												</form>
											</div>
											<div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
												<div class="kt-subheader__desc"><span id="kt_subheader_group_selected_rows"></span> Selected:</div>
												<div class="btn-toolbar kt-margin-l-20">
													<button class="btn btn-label-danger btn-bold btn-sm btn-icon-h" id="kt_subheader_group_actions_delete_all">
														Delete All
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- end:: Content Head -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">

									<!--begin::Portlet-->
									<div class="kt-portlet kt-portlet--mobile">
										<div class="kt-portlet__body kt-portlet__body--fit">

											<!--begin: Datatable -->
											<div class="kt-datatable" id="kt_payer_logs_datatable"></div>

											<!--end: Datatable -->
										</div>
									</div>

									<!--end::Portlet-->

									<!--begin::Modal-->
									<div class="modal fade" id="kt_datatable_records_fetch_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Selected Records</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true"></span>
													</button>
												</div>
												<div class="modal-body">
													<div class="kt-scroll" data-scroll="true" data-height="200">
														<ul id="kt_apps_user_fetch_records_selected"></ul>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-brand" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>

									<!--end::Modal-->
								</div>

								<!-- end:: Content -->
							</div>
						</div>
					</div>

					<!-- begin:: Footer -->
					<?php require_once ("footer.php"); ?>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->
		<?php require_once ("footer-js.php"); ?>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/logs.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>