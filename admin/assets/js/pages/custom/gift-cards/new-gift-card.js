"use strict";

// Class Definition
var KTNewGiftCard = function() {

    var handleNewGiftCard = function() {
        $('#new_gift_card_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    name: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                    short_desc: {
                        required: true
                    },
                    description: {
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
                url: endPoint + "new-gift-card.php",
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        $('.kt-datatable').KTDatatable('reload');
                        swal.fire({
                            "title": "Gift Card New",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        window.location.assign("gift-cards/");
                    } else {
                        swal.fire({
                            "title": "Gift Card New Error",
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
            handleNewGiftCard();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTNewGiftCard.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
});