'use strict';
// Class definition

var KTDatatableOrders = function() {
	// Private functions

	// loadOrders initializer
	var loadOrders = function() {

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
	                    method: 'GET',
	                    params: {
	                        // getTransactionId() method has been defined in assets/js/pages/custom/general/generals.js
	                        transaction_id: getTransactionId(),
	                        employee_id: getCookie("employee_id"),
	                        user_ses_id: getCookie("user_ses_id"),
	                        status: order_status,
	                        vendor_id: vendor_id
	                    },
						url: endPoint + 'get-vendor-orders.php',
						// url: 'http://localhost/test-aws/katlogg-admin/engine/actions/get-orders.php',
					},
				},
				pageSize: 10, // display 20 records per page
				serverPaging: true,
				serverFiltering: false,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: false,
				height: null,
				footer: false,
			},

			// column sorting
			sortable: true,

			pagination: true,

			detail: {
				title: 'Load sub table',
				content: subTableInit,
			},

			search: {
				input: $('#generalSearch'),
			},

			// columns definition
			columns: [
				{
					field: 'id',
					title: '',
					sortable: false,
					width: 30,
					textAlign: 'center',
				}, {
					field: 'checkbox',
					title: '',
					template: '{{id}}',
					sortable: false,
					width: 20,
					textAlign: 'center',
					selector: {class: 'kt-checkbox--solid'},
				}, {
					field: 'order_no',
					title: 'Order No',
				}, {
					field: 'first_name',
					title: 'Name',
					// sortable: 'asc',
					// callback function support for column rendering
					template: function(row) {
						return row.first_name + ' ' + row.last_name;
					},
				}, {
					field: 'total_amount',
					title: 'Amount',
				}, {
					field: 'order_status',
					title: 'Status',
					// callback function support for column rendering
					template: function(row) {
						var status = {
							1: {'title': 'Pending', 'class': 'kt-badge--warning'},
							2: {'title': 'Rejected', 'class': ' kt-badge--danger'},
							3: {'title': 'Cancelled', 'class': ' kt-badge--danger'},
							4: {'title': 'Accepted', 'class': ' kt-badge--primary'},
							6: {'title': 'Delivered', 'class': ' kt-badge--success'},
							10: {'title': 'Awaiting', 'class': ' kt-badge--dark'},
							5: {'title': '5555', 'class': ' kt-badge--dark'},
							11: {'title': '11111', 'class': ' kt-badge--dark'},
						};
						return '<span class="kt-badge ' + status[row.order_status].class + ' kt-badge--inline kt-badge--pill">' + status[row.order_status].title + '</span>';
					},
				}, {
		            field: 'date_time',
		            title: 'Order Date',
		            autoHide: false,
		        }],
		});

		$('#kt_form_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'order_status');
		});

		// $('#kt_form_type').on('change', function() {
		// 	datatable.search($(this).val().toLowerCase(), 'Type');
		// });

		// $('#kt_form_status,#kt_form_type').selectpicker();

		function subTableInit(e) {
			console.log(e);
			$('<div/>').attr('id', 'child_data_ajax_' + e.data.id).appendTo(e.detailCell).KTDatatable({
				data: {
					type: 'remote',
					source: {
						read: {
							url: endPoint + 'get-carts.php',
							// url: 'http://localhost/test-aws/katlogg-admin/engine/actions/get-carts.php',
							params: {
								// custom query params
								transaction_id: getTransactionId(),
		                        employee_id: getCookie("employee_id"),
		                        user_ses_id: getCookie("user_ses_id"),
		                        status: order_status,
		                        order_id: e.data.id,
								query: {
									generalSearch: '',
									order_id: e.data.id,
								},
							},
						},
					},
					pageSize: 10,
					serverPaging: true,
					serverFiltering: false,
					serverSorting: true,
				},

				// layout definition
				layout: {
					scroll: true,
					height: 300,
					footer: false,

					// enable/disable datatable spinner.
					spinner: {
						type: 1,
						theme: 'default',
					},
				},

				sortable: true,

				// columns definition
				columns: [
					{
						field: 'cart_id',
						title: '#',
						sortable: false,
						width: 30,
					}, {
			            field: "image_urls",
			            title: "Image",
			            autoHide: false,
			            // callback function support for column rendering
			            template: function(row) {
			                var images = row.image_urls;
			                images = images.split('|');
			                var output = '\
			                    <div class="kt-user-card-v2 kt-user-card-v2--uncircle">\
			                        <div class="kt-user-card-v2__pic">\
			                            <a href=""><img style="height:35px;" src="' + images[0] + '" alt="photo"></a>\
			                        </div>\
			                    </div>';

			                return output;
			            }
			        }, {
						field: 'name',
						title: 'Product Name',
					}, {
						field: 'price',
						title: 'Price',
					}, {
						field: 'qty',
						title: 'Qty',
					}, {
						field: 'total_amount',
						title: 'Total_amount',
					}],
			});
		}
	};

	return {
		// Public functions
		init: function() {
			// init dmeo
			loadOrders();
		},
	};
}();

jQuery(document).ready(function() {
	KTDatatableOrders.init();
});