"use strict";

// Class Definition
var KTSignUp = function() {

    var login = $('#kt_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">'+msg+'</div>\
			<div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        // KTUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }

    // Private Functions
    var displaySignInForm = function() {
        window.location.replace("login");
    }

    var handleFormSwitch = function() {
        $('#kt_login_signup_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });
    }

    var handleSignUpFormSubmit = function() {
        $('#kt_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    tin: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    agree: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);

                        var signInForm = login.find('.kt-login__signin form');
                        if (response['success']) {
                            form.clearForm();
                            form.validate().resetForm();
                            showErrorMsg(signInForm, 'success', 'Thank you. To complete your process, please check your email.');
                        } else {
                            showErrorMsg(signInForm, 'warning', response['message']);
                        }
                    }, 2000);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleFormSwitch();
            handleSignUpFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#transaction_id").val(getTransactionId());
    KTSignUp.init();
});
