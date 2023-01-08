"use strict";

// Class Definition
var KTSendNotification = function() {

    var handleSendNotification = function() {
        $('#send_notification_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    send_to: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    message: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                },
                messages:
                {
                    send_to: "Please select target users",
                    title: "Please enter title",
                    message: "Please enter message",
                    type: "Please select notification type",
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
                url: awsEndPoint + "send-push-notification.php",
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Notification Sent",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    } else {
                        swal.fire({
                            "title": "Notification Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
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
            handleSendNotification();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTSendNotification.init();
    $(".transaction_id").val(getTransactionId());
    $(".admin_username").val(getCookie("admin_username"));
});