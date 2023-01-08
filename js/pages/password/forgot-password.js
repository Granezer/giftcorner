"use strict";

// Class Definition
var ForgotPassword = function() {

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">\
			'+msg+'\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                <span aria-hidden="true">×</span>\
            </button>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
    }

    var handleForgotFormSubmit = function() {
        $('#forgot_password').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages:
                {
                  email:
                  {
                    required: "Please enter a valid email address."
                  }
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
            var params = $("form").serialize();

            $.ajax({
                type: "POST",
                url: endPoint + "users/forgot-password",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                	setTimeout(function() {
                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
                        $("#login-response").html(response['message']);

                        if (response['success']) {
                            setTimeout(function (){
                                window.location.assign("reset-password")
                            },2000);  
                        } 
                    },10);
                },
                error: function(error) {
                    console.log(error);
                    // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleForgotFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#transaction_id").val(getTransactionId());
    ForgotPassword.init();
});