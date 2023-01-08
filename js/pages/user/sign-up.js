"use strict";

// Class Definition
var SignUp = function() {

    var handleSignUpFormSubmit = function() {
        $('#sign_up_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    fullname: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    password2: {
                        equalTo: "#password"
                    }
                },
                messages:
                {
                    fullname:
                    {
                        required: "Please enter your name"
                    },
                    phone:
                    {
                        required: "Please enter your phone number"
                    },
                    email:
                    {
                        required: "Please enter a valid email address."
                    },
                    password:
                    {
                        required: "Password must not be empty",
                        minlength: "Password should be at least 8 characters"
                    },
                }
            });

            if (!form.valid()) {
                return;
            }

            var redirect = $("#url").val();

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var params = $("form").serialize();
            $.ajax({
                type: "POST",
                url: endPoint + "users/registration.php",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                    setTimeout(function() {
                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
                        if (response['success']) {
                            window.location.replace(redirect);
                        } else {
                            $("#response").html(response['message']);
                        }
                    },100);
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
            handleSignUpFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#transaction_id").val(getTransactionId());
    SignUp.init();
});