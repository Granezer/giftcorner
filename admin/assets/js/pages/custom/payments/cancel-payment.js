"use strict";

// Class Definition
var KTCancelPayment = function() {

    var handleCancelPayment = function() {
        $('#cancel_payment_submit').click(function(e) {
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
                url: endPoint + "cancel-payment.php",
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Payment Cancelled",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function() {
                            window.location.reload(true);
                        },2000);
                    } else {
                        swal.fire({
                            "title": "Payment Cancellation Failed",
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
            handleCancelPayment();
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTCancelPayment.init();
});