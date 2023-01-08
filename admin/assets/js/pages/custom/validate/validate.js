"use strict";

// Class Definition
var KTValidateGiftCard = function() {

    var handleValidateGiftCard = function() {
        $('#validate_gift_card_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    card_number: {
                        required: true
                    },
                    card_pin: {
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
                url: endPoint + "validate-gift-card.php",
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Gift Card Validated",
                            "text": "Card successfully validated",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });

                        var params = "card_number=" + $("#card_number").val() + "&card_pin=" + $("#card_pin").val();
                        setTimeout(function(){
                            window.location.assign("validate/card-details?"+params);
                        },2000);
                    } else {
                        swal.fire({
                            "title": "Gift Card Validate Error",
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
            handleValidateGiftCard();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTValidateGiftCard.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
});