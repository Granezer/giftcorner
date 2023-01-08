"use strict";

// Class Definition
var KTEditDepartmentSetting = function() {

    // add new patient ot list
    var getDepartmentSetting = function() {

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
            url: endPoint + 'settings/get-departments',
            data:params,
            dataType: 'json',
            headers: { 'Authorization': api_key },
            // cache:false,
            success:function(response) {
                let data = response['data'];
                if (data) {
                        
                    $("#id").val(data.id);
                    $("#name").val(data.name);
                }  else {
                    checkAccess(response['message']);
                }    
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    var handleEditDepartmentSetting = function() {
        $('#edit_department_setting_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    name: {
                        required: true
                    },
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
                url: endPoint + "settings/edit-department",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Success",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        window.location.assign("settings/department-settings");
                    } else {
                        checkAccess(response['message']);
                        $(".transaction_id").val(getTransactionId());
                        swal.fire({
                            "title": "Update Department Setting Error",
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
            getDepartmentSetting();
            handleEditDepartmentSetting();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTEditDepartmentSetting.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
}); 