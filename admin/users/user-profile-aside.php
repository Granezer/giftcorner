<button class="kt-app__aside-close" id="kt_user_profile_aside_close">
	<i class="la la-close"></i>
</button>
<div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

	<!--begin:: Widgets/Applications/User/Profile1-->
	<div class="kt-portlet kt-portlet--height-fluid-">
		<div class="kt-portlet__head  kt-portlet__head--noborder">
			<div class="kt-portlet__head-label">
				<h3 class="kt-portlet__head-title">
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body kt-portlet__body--fit-y">

			<!--begin::Widget -->
			<div class="kt-widget kt-widget--user-profile-1">
				<div class="kt-widget__head">
					<div class="kt-widget__media">
						<img src="<?php echo $response['profile_image_url'] ?>" alt="image">
					</div>
					<div class="kt-widget__content">
						<div class="kt-widget__section">
							<a href="#" class="kt-widget__username">
								<?php echo $response['fullname'] ?>
								<i class="flaticon2-correct kt-font-success"></i>
							</a>
						</div>
						<div class="kt-widget__action">
							<a href="users/user-orders?user_id=<?php echo $response['id'] ?>" class="btn btn-info btn-sm" style="color: #fff">Orders</a>&nbsp;
							<a href="users/wish-lists?user_id=<?php echo $response['id'] ?>" class="btn btn-success btn-sm" style="color: #fff">Wish List</a>
						</div>
					</div>
				</div>
				<div class="kt-widget__body">
					<div class="kt-widget__content">
						<div class="kt-widget__info">
							<span class="kt-widget__label">Email:</span>
							<a href="#" class="kt-widget__data"><?php echo $response['email'] ?></a>
						</div>
						<div class="kt-widget__info">
							<span class="kt-widget__label">Phone:</span>
							<a href="#" class="kt-widget__data"><?php echo $response['phone'] ?></a>
						</div>
					</div>
					<div class="kt-widget__items">
						<!-- <a href="users/overview?user_id=<?php echo $response['id'] ?>" class="kt-widget__item <?php if($pageName == 'user-profile-overview') echo 'kt-widget__item--active'; ?>">
							<span class="kt-widget__section">
								<span class="kt-widget__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24" />
											<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
											<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
										</g>
									</svg> </span>
								<span class="kt-widget__desc">
									Profile Overview
								</span>
							</span>
						</a> -->
						<a href="users/personal-information?user_id=<?php echo $response['id'] ?>" class="kt-widget__item <?php if($pageName == 'user-personal-information') echo 'kt-widget__item--active'; ?>">
							<span class="kt-widget__section">
								<span class="kt-widget__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24" />
											<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
										</g>
									</svg> </span>
								<span class="kt-widget__desc">
									Personal Information
								</span>
							</span>
						</a>
						<a href="users/user-orders?user_id=<?php echo $response['id'] ?>" class="kt-widget__item <?php if($pageName == 'merchant-user-orders') echo 'kt-widget__item--active'; ?>" data-toggle="kt-tooltip" data-placement="right">
							<span class="kt-widget__section">
								<span class="kt-widget__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
											<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L12.5,10 C13.3284271,10 14,10.6715729 14,11.5 C14,12.3284271 13.3284271,13 12.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
										</g>
									</svg> </span>
								<span class="kt-widget__desc">
									Orders
								</span>
							</span>
						</a>
						<a href="users/shipping-address?user_id=<?php echo $response['id'] ?>" class="kt-widget__item<?php if($pageName == 'shipping-address') echo 'kt-widget__item--active'; ?>" data-toggle="kt-tooltip" data-placement="right">
							<span class="kt-widget__section">
								<span class="kt-widget__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
											<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L12.5,10 C13.3284271,10 14,10.6715729 14,11.5 C14,12.3284271 13.3284271,13 12.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
										</g>
									</svg> </span>
								<span class="kt-widget__desc">
									Shipping Address
								</span>
							</span>
						</a>
						<a href="users/payments?user_id=<?php echo $response['id'] ?>" class="kt-widget__item <?php if($pageName == 'user-payments') echo 'kt-widget__item--active'; ?>" data-toggle="kt-tooltip" data-placement="right">
							<span class="kt-widget__section">
								<span class="kt-widget__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" x="2" y="5" width="19" height="4" rx="1" />
											<rect fill="#000000" opacity="0.3" x="2" y="11" width="19" height="10" rx="1" />
										</g>
									</svg> </span>
								<span class="kt-widget__desc">
									Payments
								</span>
							</span>
						</a>
					</div>
				</div>
			</div>

			<!--end::Widget -->
		</div>
	</div>

	<!--end:: Widgets/Applications/User/Profile1-->
</div>