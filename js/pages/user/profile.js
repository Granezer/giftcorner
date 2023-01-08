"use strict";

// Class Definition
var Profile = function() {

    var handleUpdateProfile = function() {
        $('#update_profile_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    fullname: {
                        required: true,
                    },
                    phone: {
                        required: true
                    },
                    gender: {
                        required: true
                    }
                },
                messages:
                {
                  fullname:
                  {
                    required: "Please enter your fullname"
                  },
                  phone:
                  {
                    required: "Please enter your phone number"
                  },
                  gender:
                  {
                    required: "Please select your gender"
                  }
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var params = $("form").serialize();
            $.ajax({
                type: "POST",
                url: endPoint + "users/update-profile.php",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                    setTimeout(function() {
                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
                        $(".transaction_id").val(getTransactionId());
                        $("#response").html(response['message']);
                    },10);
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
            handleUpdateProfile();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $(".transaction_id").val(getTransactionId());
    Profile.init();
});