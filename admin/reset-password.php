<?php
require_once("check-login.php"); 
$email = isset($_GET['email']) ? $_GET['email'] : null;
if (!$email) {
    header("Location: ./");
    exit();
}
?>

<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>Login | <?php echo $site_title; ?></title>
		<meta name="description" content="Login page example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="assets/css/pages/login/login-3.css" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<?php require_once ("head-css.php"); ?>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin::Page loader -->

		<!-- end::Page Loader -->

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(assets/media/bg/bg-3.jpg);">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__logo">
								<a href="#">
									<img src="assets/media/logos/gift-corner-ng-logo.png" style="height: 100px; width: 100px;">
								</a>
							</div>
							<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Reset your Password</h3>
								</div>
								
								<form class="kt-form">
									<div class="col-12">
	                                    <div class="alert alert-danger alert-dismissible">
	                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                                        Check your Email. Reset code has been sent to you.
	                                    </div>
	                                </div>
									<div class="form-group">
										<input class="form-control" type="Password" placeholder="New password" name="password" id="password">
									</div>
									<div class="form-group">
										<input class="form-control" type="Password" placeholder="Confirm password" name="confirm_password" id="confirm_password">
										<input type="hidden" name="transaction_id" class="transaction_id">
										<input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
									</div>
									<div class="form-group">
										<input class="form-control form-control-last" type="text" placeholder="Reset code" name="code" onkeypress="return numbers(event,this.id)">
									</div>
									<div class="row kt-login__extra">
										<div class="col kt-align-left">
											<label class="kt-checkbox">
												
											</label>
										</div>
										<div class="col kt-align-right">
											<a href="./" class="kt-link">I know my password ?</a>
										</div>
									</div>
									<div class="kt-login__actions">
										<button id="kt_reset_password_submit" type="button" class="btn btn-brand btn-pill btn-elevate">Reset Password</button>
									</div>
								</form>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<?php require_once("footer-js.php");?>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/profile/reset-password.js?p=1" type="text/javascript"></script>
	</body>

	<!-- end::Body -->
</html>