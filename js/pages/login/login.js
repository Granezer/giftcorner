"use strict";

// Class Definition
var Login = function() {

    var handleSignInFormSubmit = function() {
        $('#login_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages:
                {
                  password:
                  {
                    required: "Please enter your password"
                  },
                  email:
                  {
                    required: "Please enter a valid email address."
                  }
                }
            });

            if (!form.valid()) {
                return;
            }

            var redirect = $("#url").val();

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var params = $("#login-form-wrap").serialize();
            // var params = new FormData($('#login-form-wrap')[0]);
            $.ajax({
                type: "POST",
                url: endPoint + "users/login.php",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                    setTimeout(function() {
                        $("#transaction_id").val(getTransactionId());
                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
                        if (response['success']) {
                            window.location.replace(redirect);
                        } else {
                            $("#login-response").html(response['message']);
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
            handleSignInFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#email").val(getCookie("loginEmail"));
    $("#password").val(getCookie("loginPassword"));
    $("#transaction_id").val(getTransactionId());
    Login.init();
});

// set cookies
document.getElementById("remember-me").addEventListener("change",
    function() {
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        var loginEmail = '';
        var loginPassword = '';

        if ($(this).val() == 0) {
            $(this).val(1);
            loginEmail = $("#email").val();
            loginPassword = $("#password").val();
        } else {
            $(this).val(0);
        }
        
        var expires = "expires="+ d.toUTCString();
        document.cookie = "loginEmail=" + loginEmail + ";" + expires + ";path=/";
        document.cookie = "loginPassword=" + loginPassword + ";" + expires + ";path=/";    
    }
);