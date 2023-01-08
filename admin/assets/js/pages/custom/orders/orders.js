"use strict";
// Class definition

var KTDatatableProducts = function() {
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
                        status: order_status
                    },
                    url: endPoint + 'get-orders.php',
                    // url: 'http://localhost/test-aws/katlogg-admin/engine/actions/get-orders.php',
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
                message: 'Please wait! Loading orders...',
            },
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition

        columns: [
        	{
				field: 'checkbox',
				title: '',
				template: '{{id}}',
				sortable: false,
				width: 20,
				textAlign: 'center',
				selector: {class: 'kt-checkbox--solid'},
			}, {
				field: 'reference_no',
				title: 'Order No',
	            // callback function support for column rendering
	            template: function(row) {
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">#'+ row.reference_no +'</a>';

	                return output;
	            }
			}, {
				field: 'first_name',
				title: 'Buyer Name',
				// sortable: 'asc',
				// callback function support for column rendering
				template: function(row) {
					var name = row.first_name + ' ' + row.last_name;
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">'+ name +'</a>';

	                return output;
				},
			}, {
				field: 'phone',
				title: 'Phone',
	            // callback function support for column rendering
	            template: function(row) {
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">'+ row.phone +'</a>';

	                return output;
	            }
			}, {
				field: 'email',
				title: 'Email',
	            // callback function support for column rendering
	            template: function(row) {
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">'+ row.email +'</a>';

	                return output;
	            }
			}, {
				field: 'address',
				title: 'Shipping Address',
	            // callback function support for column rendering
	            template: function(row) {
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">'+ row.address +'</a>';

	                return output;
	            }
			}, {
				field: 'total_amount',
				title: 'Amount',
	            // callback function support for column rendering
	            template: function(row) {
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">NGN '+ row.total_amount +'</a>';

	                return output;
	            }
			}, {
				field: 'order_status',
				title: 'Status',
	            autoHide: false,
				// callback function support for column rendering
				template: function(row) {
					var status = {
						1: {'title': 'Pending', 'class': 'kt-badge--warning'},
						2: {'title': 'Rejected', 'class': ' kt-badge--danger'},
						3: {'title': 'Cancelled', 'class': ' kt-badge--danger'},
						4: {'title': 'Confirmed', 'class': ' kt-badge--primary'},
						6: {'title': 'Delivered', 'class': ' kt-badge--success'},
						10: {'title': 'Awaiting', 'class': ' kt-badge--dark'},
						11: {'title': 'Pending Pickup', 'class': ' kt-badge--info'},
						5: {'title': 'Pending Delivery', 'class': ' kt-badge--brand'},
					};
					return '<span class="kt-badge ' + status[row.order_status].class + ' kt-badge--inline kt-badge--pill"><a href="payments/user-payment-details?id=' + row.id + '" style="color:#fff;">' + status[row.order_status].title + '</a></span>';
				},
			}, {
	            field: 'date_time',
	            title: 'Date Created',
	            autoHide: false,
	            // callback function support for column rendering
	            template: function(row) {
	                var output = '\
	                    <a href="orders/order-details?id=' + row.id + '" style="color:#666;">'+ row.date_time +'</a>';

	                return output;
	            }
	        }, {
				field: '',
				width: 110,
				title: 'Actions',
				sortable: false,
				overflow: 'visible',
				autoHide: false,
				template: function(row) {
					return '\
	                  <div class="dropdown">\
	                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
	                          <i class="la la-ellipsis-h"></i>\
	                      </a>\
	                      <div class="dropdown-menu dropdown-menu-right">\
	                          <a class="dropdown-item" href="orders/order-details?id=' + row.id + '"><i class="la la-eye"></i> View Details</a>\
	                      </div>\
	                  </div>\
	              ';
				},
			}],
    };

    // basic demo
    var loadProducts = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_orders').KTDatatable(options);

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
            });

        $('#kt_modal_fetch_order_id_to_delete').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var order_ids = [];
            $("#delete-msg").html("Are you sure you want to delete the below listed order id(s)?");
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Product ID: ' + ids[i];
                c.appendChild(li);
                order_ids[i] = ids[i];
            }
            $("#order_ids").val(order_ids);
            $(e.target).find('.kt-datatable_selected_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_ids').empty();
        });

        $('#kt_modal_fetch_order_id_to_update').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var order_ids = [];
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Product ID: ' + ids[i];
                c.appendChild(li);
                order_ids[i] = ids[i];
            }
            $("#ids").val(order_ids);
            $(e.target).find('.kt-datatable_selected_order_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_order_ids').empty();
        });

    };

    return {
        // public functions
        init: function() {
            loadProducts();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableProducts.init();
});