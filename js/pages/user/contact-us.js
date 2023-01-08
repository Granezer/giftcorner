"use strict";

// Class Definition
var ContactUs = function() {

    var handleContactUs = function() {
        $('#contact_us_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true
                    },
                    subject: {
                        required: true
                    },
                    message: {
                        required: true
                    },
                },
                messages:
                {
                    name: "Please enter your name",
                    email: "Please enter your email address",
                    phone: "Please enter your phone number",
                    subject: "Please enter subject",
                    message: "Please enter your message",
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
            var params = $("form").serialize();

            $.ajax({
                type: "POST",
                url: endPoint + "users/contact-us",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    if (response['success']) {
                        $("form").trigger("reset");
                        $("#transaction_id").val(getTransactionId());
                    } 

                    $("#response").html(response['message']);
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
            handleContactUs();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#transaction_id").val(getTransactionId());
    ContactUs.init();
});