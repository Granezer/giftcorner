"use strict";

// Class Definition
var KTUpdateProductStatus = function() {

    var handleUpdateProductStatus = function() {
        $('#kt_datatable_update_products_status').click(function(e) {
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
                url: endPoint + "update-product-status.php",
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        $('.kt-datatable').KTDatatable('reload');
                        swal.fire({
                            "title": "Products Status Updated",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        $('#kt_modal_fetch_product_id_to_update').modal('hide');
                    } else {
                        swal.fire({
                            "title": "Products Status Error",
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

    // Public Functions
    return {
        // public functions
        init: function() {
            handleUpdateProductStatus();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTUpdateProductStatus.init();
});