"use strict";
// Class definition

var KTPayerActivityLogs = function() {

	// variables
	var datatable;

	// init
	var init = function() {

		// init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
		datatable = $('#kt_payer_logs_datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						method: 'GET',
						params: {
							// getTransactionId() method has been defined in assets/js/generals.js
							transaction_id: getTransactionId(),
							payer_id: getCookie("payer_id"),
							payer_type: getCookie("payer_type"),
							user_ses_id: getCookie("user_ses_id")
						},
						// endPoint variable has been defined in assets/js/generals.js
						url: endPoint + 'activity-logs',
					},
				},
				saveState: {
					webstorage: false,
				},
				pageSize: 20, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// kt-datatable--on-ajax-done: {

			// },

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
				spinner: {
					message: "Loading table data. Please wait...",
				},
			},
			
			toolbar: {
				items: {
					pagination: {
						pageSizeSelect: [10, 20, 30, 50, 75, 100, 125, 150, 175, 200]
					}
				}
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch'),
				delay: 400,
			},

			// columns definition
			columns: [{
				field: 'id',
				title: '#',
				sortable: false,
				width: 20,
				selector: {
					class: 'kt-checkbox--solid'
				},
				textAlign: 'center',
			}, {
				field: "fullname",
				title: "Name",
			}, {
				field: 'report_type',
				title: 'Activity Name',
			}, {
				field: 'description',
				title: 'Description',
			}, {
				field: 'date_time',
				title: 'Date Created',
				// type: 'date',
				// format: 'MM/DD/YYYY',
			}]
		});

		console.log(datatable);
        
	}

	// search
	var search = function() {
		$('#kt_form_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});
	}

	var updateTotal = function() {
		datatable.on('kt-datatable--on-layout-updated', function () {
			$('#kt_subheader_total').html(datatable.getTotalRows() + ' Total Records');
		});
	};

	return {
		// public functions
		init: function() {
			init();
			search();
			updateTotal();
		},
	};
}();

// On document ready
KTUtil.ready(function() {
	KTPayerActivityLogs.init();
});