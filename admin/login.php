<?php
require_once("check-login.php"); 
// echo password_hash('pass1234', PASSWORD_DEFAULT);exit
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
									<h3 class="kt-login__title">Sign In To Admin Portal</h3>
								</div>
								<?php
								if (isset($_SESSION["error"])) {
								?>
									<div class="alert alert-bold alert-solid-warning alert-dismissible" role="alert">
										<div class="alert-text"><?php echo $_SESSION["error"]; ?></div>
										<div class="alert-close">
							                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>
							            </div>
									</div>

								<?php
									unset($_SESSION["error"]);
								}
								?>
								<form class="kt-form" action="">
									<div class="input-group">
										<input class="form-control" type="email" placeholder="Email" name="email" autocomplete="off" id="login-email">
										<input type="hidden" name="transaction_id" id="transaction_id1">
									</div>
									<div class="input-group">
										<input class="form-control form-control-last" type="Password" placeholder="Password" name="password" id="login-password">
									</div>
									<div class="row kt-login__extra">
										<div class="col">
											<label class="kt-checkbox" for="remember-me">
												<input type="checkbox" id="remember-me" name="remember" value="0"> Remember me
												<span></span>
											</label>
										</div>
										<div class="col kt-align-right">
											<a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
										</div>
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign In</button>
									</div>
								</form>
							</div>

							<div class="kt-login__forgot">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Forgotten Password ?</h3>
									<div class="kt-login__desc">Enter your email to reset your password:</div>
								</div>
								<form class="kt-form" action="">
									<input type="hidden" name="transaction_id" id="transaction_id2">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="email" id="email" autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_forgot_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Request</button>&nbsp;&nbsp;
										<button id="kt_login_forgot_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</button>
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
		<script src="assets/js/pages/custom/login/login-general.js?p=4" type="text/javascript"></script>
	</body>

	<!-- end::Body -->
</html>