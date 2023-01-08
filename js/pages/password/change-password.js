"use strict";

// Class Definition
var ChangePassword = function() {

    var handleChangePassword = function() {
        $('#change_password_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    current_password: {
                        required: true
                    },
                    new_password: {
                        required: true,
                        minlength: 8
                    },
                    new_password2: {
                        equalTo: "#new_password"
                    }
                },
                messages:
                {
                    new_password:
                    {
                        required: "Password must not be empty",
                        minlength: "Password should be at least 8 characters"
                    },
                    current_password: "Current password is required",
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
            var params = $("form").serialize();

            $.ajax({
                type: "POST",
                url: endPoint + "users/change-password",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    console.log(response);
                	// similate 2s delay
                	setTimeout(function() {
                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
                        $(".transaction_id").val(getTransactionId());
                        $("#response2").html(response['message']);
                    },1000);
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
            handleChangePassword();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    ChangePassword.init();
});