"use strict";

// Class Definition
var KTUpdateOrderStatus = function() {

    var handleUpdateOrderStatus = function() {
        $('#kt_datatable_update_orders_status').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            // form.validate({
            //     rules: {
            //         description: {
            //             required: true
            //         },
            //     },
            // });

            // if (!form.valid()) {
            //     return;
            // }
            
            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
            
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            form.ajaxSubmit({
                type: "POST",
                url: endPoint + "update-order-status.php",
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        $('.kt-datatable').KTDatatable('reload');
                        swal.fire({
                            "title": "Orders Status Updated",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        $('#kt_modal_fetch_order_id_to_update').modal('hide');
                    } else {
                        swal.fire({
                            "title": "Orders Status Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                },
                error: function(error) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    console.log(error);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleUpdateOrderStatus();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTUpdateOrderStatus.init();
});