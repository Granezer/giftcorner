"use strict";

// Class Definition
var KTResetPassword = function() {

    var handleResetPassword = function() {
        $('#kt_reset_password_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    code: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                },
                messages:
                {
                    code: "Please enter reset code",
                    password:
                    {
                        required: "Password must not be empty",
                        minlength: "Password should be at least 8 characters"
                    },
                    confirm_password: "Password not match",
                }
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
                url: endPoint + "reset-password",
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Password Changed",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function (){
                            window.location.assign("login");
                        },2000);
                    } else {
                        swal.fire({
                            "title": "Password Error",
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

    var handleChangePassword = function() {
        $('#kt_change_password_submit').click(function(e) {
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
                    confirm_password: {
                        equalTo: "#new_password"
                    },
                },
                messages:
                {
                    current_password: "Please enter current password",
                    new_password:
                    {
                        required: "New password must not be empty",
                        minlength: "New password should be at least 8 characters"
                    },
                    confirm_password: "Password not match",
                }
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
                url: endPoint + "change-password",
                success: function(response, status, xhr, $form) {
                    $(".transaction_id").val(getTransactionId());
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        form[0].reset();
                        swal.fire({
                            "title": "Password Changed",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    } else {
                        swal.fire({
                            "title": "Password Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                },
                error: function(error) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    console.log(error);
                    $(".transaction_id").val(getTransactionId());
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleResetPassword();
            handleChangePassword();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTResetPassword.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
});