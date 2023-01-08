"use strict";

// Class Definition
var KTDeleteProduct = function() {

    var handleDeleteProduct = function() {
        $('#kt_datatable_delete_all_products').click(function(e) {
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
                url: endPoint + "delete-product.php",
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        $('.kt-datatable').KTDatatable('reload');
                        swal.fire({
                            "title": "Product Deleted",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        $('#kt_modal_fetch_product_id_to_delete').modal('hide');
                    } else {
                        swal.fire({
                            "title": "Product Delete Error",
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
            handleDeleteProduct();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTDeleteProduct.init();
});