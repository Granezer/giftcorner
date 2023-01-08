"use strict";

// Class Definition
var ResetPassword = function() {

    var handleResetPassword = function() {
        $('#reset_password_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        equalTo: "#password"
                    }
                },
                messages:
                {
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

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
            var params = $("form").serialize();

            $.ajax({
                type: "POST",
                url: endPoint + "users/reset-password",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    $("#login-response").html(response['message']);
                	// similate 2s delay
                	if (response['success']) {
                        setTimeout(function (){
                            window.location.assign("login");
                        },2000);
                    } 
                },
                error: function(error) {
                    console.log(error);
                    // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                }
            });
        });
    }

    var verifyLink = function() {
        var code = $("#code").val();
        var token = $("#token").val();

        let transaction_id = getTransactionId();
        let params = {
            "transaction_id": transaction_id,
            "code": code,
            "token": token,
        };

        $.ajax({
            type:'GET',
            url: endPoint + 'verify-reset-password-link',
            data:params,
            dataType: 'json',
            // cache:false,
            success:function(response) {
                if (response['success']) {
                    return true;
                      
                } else {
                    swal.fire({
                        "title": "Opps! An Error has Occured",
                        "text": response['message'],
                        "type": "error",
                        "confirmButtonClass": "btn btn-success"
                    });

                    setTimeout(function() {
                        window.location.replace("login");
                    }, 2000);
                }
            },
            
        });
        
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleResetPassword();
            verifyLink();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#transaction_id").val(getTransactionId());
    ResetPassword.init();
});