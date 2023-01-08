<?php
session_start();

require_once 'constants.php';

if(!isset($_GET['code']) || !isset($_GET['token'])) {
	header("Location: login");
	exit; 
}
?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>Verify Email | Katlogg Admin</title>
		<meta name="description" content="Login page example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">

		<!--end::Fonts -->

		<!--end::Page Custom Styles -->

		<?php require_once ("head-css.php"); ?>
	</head>

	<!-- end::Head -->

	

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<div style="display: none;">
			<input type="text" id="code" readonly="" value="<?php echo $_GET['code']; ?>">
		</div>
		<div style="display: none;">
			<input type="text" id="token" readonly="" value="<?php echo $_GET['token']; ?>">
		</div>
		<!--begin::Global Theme Bundle(used by all pages) -->

		<?php require_once("footer-js.php");?>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/verify-email.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>