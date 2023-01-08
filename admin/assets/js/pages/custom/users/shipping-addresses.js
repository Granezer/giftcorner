"use strict";
// Class definition

var KTDatatableShippingAddress = function() {
    // Private functions

    var options = {
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
                        status: status,
                        user_id: user_id
                    },
                    url: endPoint + 'get-shipping-addresses.php',
                    // url: 'http://localhost/test-aws/katlogg-admin/engine/actions/get-products.php',
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
            saveState: {
                webstorage: false,
                cookie: false,
            },
        },

        // layout definition
        layout: {
            scroll: false, // enable/disable datatable scroll both horizontal and
            // vertical when needed.
            //height: 950, // datatable's body's fixed height
            footer: true, // display/hide footer

            spinner: {
                message: 'Please wait! Loading shipping addresses...',
            },
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition

        columns: [
        	{
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
				title: "User",
	        	autoHide: false,
			}, {
                field: "first_name",
                title: "Shipping Name",
                // callback function support for column rendering
                template: function(row) {
                    return row.first_name + ' ' + row.last_name;
                }
            }, {
				field: 'address',
				title: 'Address',
	        	autoHide: false,
			}, {
				field: 'status',
				title: 'Status',
	        	autoHide: false,
	            // callback function support for column rendering
	            template: function(row) {
	                var status = {
	                    1: {'title': 'Default', 'class': 'kt-badge--success'},
	                    0: {'title': '', 'class': ' '},
	                };
	                return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
	            },
			}, {
				field: 'email',
				title: 'Email',
			}, {
				field: 'phone',
				title: 'Phone',
			}, {
				field: 'postcode',
				title: 'Post Code',
			}, {
				field: 'city',
				title: 'City',
	        	autoHide: false,
			}, {
				field: 'state',
				title: 'State',
	        	autoHide: false,
			}, {
				field: 'country',
				title: 'Country',
			}, {
				field: "date_added",
				title: "Date Added",
	        	autoHide: false,
			}
		],
    };

    // basic demo
    var loadShippingAddresses = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_shipping_addresses').KTDatatable(options);

        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val(), 'status');
        });

        // $('#kt_form_status,#kt_form_type').selectpicker();

        datatable.on(
            'kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',
            function(e) {
                var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_number').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            }
        );

    };

    return {
        // public functions
        init: function() {
            loadShippingAddresses();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableShippingAddress.init();
});