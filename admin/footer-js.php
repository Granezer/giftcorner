<?php
if(!defined('FooterJs')) {
   die('Direct access not permitted');
}
?>
<!-- begin::Global Config(global config for global JS sciprts) -->
<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
	<i class="fa fa-arrow-up"></i>
</div>


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var KTAppOptions = {
		"colors": {
			"state": {
				"brand": "#5d78ff",
				"light": "#ffffff",
				"dark": "#282a3c",
				"primary": "#5867dd",
				"success": "#34bfa3",
				"info": "#36a3f7",
				"warning": "#ffb822",
				"danger": "#fd3995"
			},
			"base": {
				"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
				"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
			}
		}
	};
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->

<!--begin:: Vendor Plugins -->
<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<!-- <script src="assets/js/pages/crud/forms/widgets/select2.js" type="text/javascript"></script> -->

<!--end:: Vendor Plugins for custom pages -->

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<!-- <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script> -->

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/custom/logout/logout.js?pp=<?php echo $remove_cache;?>" type="text/javascript"></script>

<!--end::Page Vendors -->

<!--end::Page Scripts -->

<script type="text/javascript">
	$('#engagement_date, #discount_start_date, #discount_end_date, #expiration_date, #dob, #joined_date').datepicker({
        todayHighlight: true,
        format: "yyyy-mm-dd",
        autoclose:true,
    });

	// lga
    $('#lga').select2({
        placeholder: "Select lga"
    });

    // country
    $('#country').select2({
        placeholder: "Select country"
    });

    // state1
    $('#state1, #state').select2({
        placeholder: "Select state"
    });

    // category id
    $('#category_id').select2({
        placeholder: "Select category"
    });
</script>