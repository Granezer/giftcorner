"use strict";

// Class Definition
var KTEditSystemUser = function() {

    // add new patient ot list
    var getSystemUser = function() {

        var transaction_id = getTransactionId(),
            employee_id = getCookie("employee_id"),
            user_ses_id = getCookie("user_ses_id"),
            params = {
                "transaction_id": transaction_id,
                "employee_id": employee_id,
                "user_ses_id": user_ses_id,
                "id": id,
            };

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-system-users',
            data:params,
            dataType: 'json',
            headers: { 'Authorization': api_key },
            // cache:false,
            success:function(response) {
                console.log(response)
                let data = response['data'];
                if (data) {
                    setTimeout(function (){
                        $('#employees option[value="'+ data.id +'"]').prop("selected", "selected").change();
                        $('#roles option[value="'+ data.role_id +'"]').prop("selected", "selected").change();
                    },500);
                    
                }  else {
                    checkAccess(response['message']);
                }    
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    var handleEditSystemUser = function() {
        $('#edit_system_user_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    employee: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                },
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
                url: endPoint + "settings/edit-system-user",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Edit System User",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function(){
                            window.location.assign("settings/system-users");
                        }, 2000);
                    } else {
                        checkAccess(response['message']);
                        swal.fire({
                            "title": "Edit System User Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            getSystemUser();
            handleEditSystemUser();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTEditSystemUser.init();
    $(".transaction_id").val(getTransactionId());
    $(".user_ses_id").val(getCookie("user_ses_id"));
    $(".employee_id").val(getCookie("employee_id"));
});