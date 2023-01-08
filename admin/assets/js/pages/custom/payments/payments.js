"use strict";
// Class definition

var KTDatatablePayments = function() {
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
                        user_id: user_id
                    },
                    url: endPoint + 'get-payments.php',
                    // url: 'http://localhost/test-aws/katlogg-admin/engine/actions/get-user-payments.php',
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
                message: 'Please wait! Loading user\'s payments...',
            },
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition

        columns: [{
            field: 'checkbox',
                title: '',
                template: '{{id}}',
                sortable: false,
                width: 20,
                textAlign: 'center',
                selector: {class: 'kt-checkbox--solid'},
        }, {
            field: 'fullname',
            title: 'Name',
            autoHide: false,
            // callback function support for column rendering
            template: function(data) {
                var output = '\
                    <a href="payments/user-payment-details?id=' + data.id + '" style="color:#666;">'+ data.fullname +'</a>';

                return output;
            }
        }, {
            field: 'reference_no',
            title: 'Order No',
            // callback function support for column rendering
            template: function(data) {
                var output = '\
                    <a href="payments/user-payment-details?id=' + data.id + '" style="color:#666;">#'+ data.reference_no +'</a>';

                return output;
            }
        }, {
            field: 'amount_paid',
            title: 'Amount Paid',
            // callback function support for column rendering
            template: function(data) {
                var output = '\
                    <a href="payments/user-payment-details?id=' + data.id + '" style="color:#666;">NGN '+ data.amount_paid +'</a>';

                return output;
            }
        }, {
            field: 'status',
            title: 'Status',
            autoHide: false,
            // callback function support for column rendering
            template: function(row) {
                var s = 1;
                if (row.status == "Pending") s = 2;
                if (row.status == "Cancelled") s = 3;
                
                var status = {
                    1: {'title': 'Confirmed', 'class': 'kt-badge--success'},
                    2: {'title': 'Pending', 'class': ' kt-badge--warning'},
                    3: {'title': 'Cancelled', 'class': ' kt-badge--danger'},
                };
                return '<span class="kt-badge ' + status[s].class + ' kt-badge--inline kt-badge--pill"><a href="payments/user-payment-details?id=' + row.id + '" style="color:#fff;">' + status[s].title + '</a></span>';
            },
        }, {
            field: 'transaction_reference_no',
            title: 'Transaction Reference',
            // callback function support for column rendering
            template: function(data) {
                var output = '\
                    <a href="payments/user-payment-details?id=' + data.id + '" style="color:#666;">'+ data.transaction_reference_no +'</a>';

                return output;
            }
        }, {
            field: 'date_paid',
            title: 'Date Paid',
            autoHide: false,
            // callback function support for column rendering
            template: function(data) {
                var output = '\
                    <a href="payments/user-payment-details?id=' + data.id + '" style="color:#666;">'+ data.date_paid +'</a>';

                return output;
            }
        }, {
            field: '',
            title: 'Actions',
            template: function(row) {
	            var url = '\
                    <a href="payments/user-payment-details?id=' + row.id + '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View details">\
                        <i class="la la-eye"></i>\
                    </a>\
                ';

                return url;
            },
        }],
    };

    // basic demo
    var loadPayments = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_payments').KTDatatable(options);

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

        $('#kt_modal_fetch_payment_id_to_update_status').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var payment_id = [];
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Payment ID: ' + ids[i];
                c.appendChild(li);
                payment_id[i] = ids[i];
            }
            $("#payment_id").val(payment_id);
            $(e.target).find('.kt-datatable_selected_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_ids').empty();
        });

    };

    var handleConfirmPayment = function() {
        $('#kt_datatable_confirm_payment').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');
            
            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
            
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            form.ajaxSubmit({
                type: "POST",
                url: endPoint + "confirm-payment.php",
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        $('.kt-datatable').KTDatatable('reload');
                        swal.fire({
                            "title": "Payment Confirmed",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        $('#kt_modal_fetch_product_id_to_delete').modal('hide');
                    } else {
                        swal.fire({
                            "title": "Payment Confirmation Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    return {
        // public functions
        init: function() {
            loadPayments();
            handleConfirmPayment();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatablePayments.init();
});

var getPayment = function(id) {
    alert("yes");
    // $(".transaction_id").val(getTransactionId());
    // $(".admin_username").val(getCookie("admin_username"));
    // $("#payment_id").val(id);
}