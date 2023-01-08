"use strict";

// Class Definition
var KTEditCardCategory = function() {

    var handleEditCardCategory = function() {
        $('#edit_card_category_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    name: {
                        required: true
                    },
                },
            });

            if (!form.valid()) {
                return;
            }
            
            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
            
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            form.ajaxSubmit({
                type: "POST",
                url: endPoint + "settings/edit-card-category",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Edit Card Category",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function(){
                            window.location.assign("settings/card-categories");
                        }, 2000);
                    } else {
                        // checkAccess(response['message']);
                        swal.fire({
                            "title": "Edit Card Category Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleEditCardCategory();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTEditCardCategory.init();
    $(".transaction_id").val(getTransactionId());
    $(".user_ses_id").val(getCookie("user_ses_id"));
    $(".employee_id").val(getCookie("employee_id"));
});