<?php
require_once '../config.php';
$header = "orders";
$pageName = "order-details";

$id  = isset($_GET["id"]) ? $_GET["id"] : null;

if (empty($id)) {
	exit("Error processing...");
}

$params['id'] = $id;
$page = "get-orders.php?";
$response = file_get_contents($end_point . $page . http_build_query($params));
$response = json_decode($response, true);

// echo json_encode($response['data'], JSON_PRETTY_PRINT); exit();
if (!$response['data']) {
	header("Location: ../orders");
	exit;
}

$response = $response['data'];

$params['id'] = 0;
$params['order_no'] = $response['reference_no'];
$page = "get-payments.php?";
$payment = file_get_contents($end_point . $page . http_build_query($params));
$payment = json_decode($payment, true);
$payment = $payment['data'];
$payment_id = isset($payment['id']) ? $payment['id'] : 0;
// echo json_encode($payment, JSON_PRETTY_PRINT); exit();
?>

<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../">
		<meta charset="utf-8" />
		<title>Order Details | <?php echo $site_title; ?></title>
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
											<h3 class="kt-subheader__title">Order Details</h3>
											<span class="kt-subheader__separator kt-subheader__separator--v"></span>
											<span class="kt-subheader__desc">#<?php echo $response['reference_no'];?></span>
										</div>
										<div class="kt-portlet__head-toolbar">
											<div class="kt-portlet__head-wrapper">
												<a href="orders/index" class="btn btn-clean btn-icon-sm">
													<i class="la la-long-arrow-left"></i>
													Back
												</a>
											</div>
										</div>
									</div>
								</div>

								<!-- end:: Content Head -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">
									<div class="kt-portlet">
										<div class="kt-portlet__body kt-portlet__body--fit">
											<div class="kt-invoice-2">
												<div class="kt-invoice__head">
													<div class="kt-invoice__container">
														<div class="kt-invoice__brand">
															<h1 class="kt-invoice__title">Order Details</h1>
															<div class="kt-invoice__logo">
																<?php
																$status = "success";
																switch ($response['order_status']) {
																	case 1:
																	case 3:
																		$status="warning";
																		break;
																	case 2:
																		$status="danger";
																		break;
																	case 4:
																		$status="primary";
																		break;
																	case 5:
																		$status="info";
																		break;
																	case 10:
																		$status="dark";
																		break;
																	case 11:
																		$status="brand";
																		break;
																	
																	default:
																		$status="success";
																		break;
																}
																?>
																<b>Order Status</b>
																<span class="btn btn-<?php echo $status; ?>" style="text-align: center;">		<?php echo $response['status'];?>
																</span>
															</div>
														</div>
														<div class="kt-invoice__items">
															<div class="kt-invoice__item">
																<span class="kt-invoice__subtitle">DATE/TIME</span>
																<span class="kt-invoice__text"><?php echo $response['date_time'];?></span>
															</div>
															<div class="kt-invoice__item">
																<span class="kt-invoice__subtitle">ORDER NO.</span>
																<span class="kt-invoice__text"><?php echo $response['reference_no'];?></span>
															</div>
															<div class="kt-invoice__item">
																<span class="kt-invoice__subtitle">SHIPPING ADDRESS.</span>
																<span class="kt-invoice__text"><?php echo $response['address'];?></span>
															</div>
														</div>
													</div>
												</div>
												<div class="kt-invoice__body">
													<div class="kt-invoice__container">
														<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th width="65%">ITEMS</th>
																		<th width="5%">QTY</th>
																		<th width="15%">RATE(NGN)</th>
																		<th width="15%">AMOUNT(NGN)</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$qty = $amount = $total_amount = 0;
																	foreach ($response['carts'] as $cart) {
																		$images = explode("|", $cart['image_urls']);
																		$image_url = $images[0];
																		$file_ext = getFileExt($image_url);
																		$qty += $cart['qty'];
																		$amount += (float) str_replace(",", '', $cart['amount']);
																		$total_amount += (float) str_replace(",", '', $cart['total_amount']);
																	?>
																		<tr>
																			<td width="65%">
																				<?php
																				if (!in_array($file_ext, $images_ext)) {
									                                            ?>
										                                            <video style="width: 50px; height: 35px;" controls autoplay muted>
										                                                <source src="assets/media/products/<?php echo $image_url; ?>" type="video/<?php echo $file_ext; ?>">
										                                                Your browser does not support this video.
										                                            </video>
										                                        <?php
										                                        } else {
										                                            ?>
										                                            <img style="height:35px; padding-right: 5px;" src="assets/media/products/<?php echo $image_url; ?>">
										                                        <?php
										                                        }
										                                        ?>
										                                        <?php echo $cart['name'];?>
																				
																			</td>
																			<td width="5%"><?php echo $cart['qty'];?></td>
																			<td width="15%"><?php echo $cart['amount'];?></td>
																			<td class="kt-font-danger kt-font-lg" width="15%"><?php echo $cart['total_amount'];?></td>
																		</tr>
																	<?php
																	}
																	?>
																	<tr>
																		<td colspan="4"><hr></td>
																	</tr>
																	<tr>
																		<td>&nbsp;</td>
																		<td colspan="2">Sub Total Amount</td>
																		<td class="kt-font-danger kt-font-lg" width="15%"><?php echo $response['sub_total']; ?></td>
																	</tr>
																	<tr>
																		<td>&nbsp;</td>
																		<td colspan="2">Shipping Amount</td>
																		<td class="kt-font-danger kt-font-lg" width="15%"><?php echo $response['shipping_amount']; ?></td>
																	</tr>
																	<!-- <tr>
																		<td>&nbsp;</td>
																		<td colspan="2">Service Charge</td>
																		<td class="kt-font-danger kt-font-lg" width="15%"><?php echo $response['service_charge']; ?></td>
																	</tr> -->
																	<tr>
																		<td>&nbsp;</td>
																		<td colspan="2">Grand Total Amount</td>
																		<td class="kt-font-danger kt-font-lg" width="15%"><?php echo $response['total_amount']; ?></td>
																	</tr>
																	
																</tbody>
															</table>
														</div>
													</div>
												</div>

												<div class="kt-invoice__footer">
													<div class="kt-invoice__container">
														<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th>PAYMENT MODE</th>
																		<th>PREVIOUS AMOUNT PAID</th>
																		<th>AMOUNT PAID</th>
																		<th>BALANCE AMOUNT</th>
																		<th>TOTAL AMOUNT</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td><?php echo $payment['payment_mode']; ?></td>
																		<td><?php echo $payment['total_amount_paid']; ?></td>
																		<td><?php echo $payment['amount_paid']; ?></td>
																		<td>
																			<?php 
																			$total_amount = (float) str_replace(",", '', $payment['total_amount']);
																			$total_amount_paid = (float) str_replace(",", '', $payment['total_amount_paid']);
																			$amount_paid = 0;
																			if($payment['status']=="Confirmed"){
																				$amount_paid = (float) str_replace(',', '', $payment['amount_paid']);
																			}
																			echo number_format(($total_amount - $total_amount_paid - $amount_paid)); 
																			?>
																				
																		</td>
																		<td class="kt-font-danger kt-font-xl kt-font-boldest"><?php echo $payment['total_amount']; ?></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>

												<div class="kt-invoice__actions">
													<div class="kt-invoice__container">
														<form>
															<input type="hidden" name="transaction_id" class="transaction_id">
															<input type="hidden" name="employee_id" class="employee_id">
															<input type="hidden" name="user_ses_id" class="user_ses_id">
															<input type="hidden" name="payment_id" value="<?php echo $payment_id;?>">
															<?php
															if ($response['status'] =='Pending') {
															?>
																<!-- <button type="button" class="btn btn-warning btn-bold" id="cancel_payment_submit">Cancel Payment</button>
																<button type="button" class="btn btn-success btn-bold" id="confirm_payment_submit">Confirm Payment</button> -->
															<?php
															}
															?>
														</form>
													</div>
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

		<?php require_once ("../footer-js.php"); ?>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/custom/payments/confirm-payment.js" type="text/javascript"></script>
		<script src="assets/js/pages/custom/payments/cancel-payment.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>