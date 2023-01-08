"use strict";
// Class definition

var CompanySettings = function() {
    
    var getCompanySettings = function() {

        let transaction_id = getTransactionId();
        let employee_id = getCookie("employee_id");
        let user_ses_id = getCookie("user_ses_id");
        let params = {
            "transaction_id": transaction_id,
            "employee_id": employee_id,
            "user_ses_id": user_ses_id,
        };

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-company-settings',
            data:params,
            dataType: 'json',
            headers: { 'Authorization': api_key },
            // cache:false,
            success:function(response) {
                if (response['success'] == true) {
                    let data = response['data'];
                    $("#company_name").val(data.name);
                    $("#contact_person").val(data.contact_person);
                    $("#email").val(data.email);
                    $("#phone").val(data.phone);
                    $("#mobile").val(data.mobile);
                    $("#fax").val(data.fax);
                    $("#address").val(data.address);
                    $("#website").val(data.website);
                    $("#branch").val(data.branch);
                    $("#post_code").val(data.post_code);
                    $("#city").val(data.city);
                    $("#date_of_establishment").val(data.date_of_establishment);
                    $("#reg_no").val(data.reg_no);
                    $("#administrative_area").val(data.administrative_area);
                    setTimeout(function () {
                        $('#country option[value="'+ data.country +'"]').prop("selected", "selected").change();
                        $('#state1 option[value="'+ data.state +'"]').prop("selected", "selected").change();
                    }, 200);
                    
                } else {
                    
                    swal.fire({
                        "title": "Oops! Error",
                        "text": response['message'],
                        "type": "error",
                        "confirmButtonClass": "btn btn-error"
                    });
                    
                }  
            },
            error: function(error) {
                
                console.log(error);
            }
        });
    }

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

    var handleCompanySettings = function() {
        $('#company_settings_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    company_name: {
                        required: true
                    },
                    contact_person: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    post_code: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    branch: {
                        required: true
                    },
                    date_of_establishment: {
                        required: true
                    },
                    reg_no: {
                        required: true
                    },
                },
                messages:
                {
                  company_name: "Please enter hospital name",
                  contact_person: "Please enter contact person",
                  address: "Please enter address",
                  phone: "Please enter phone number",
                  country: "Please select country",
                  state:"Please select state",
                  city: "Please enter city",
                  post_code: "Please eneter post code",
                  branch: "Please eneter branch",
                  email: "Please enter a valid email address.",
                  date_of_establishment: "Please eneter date of establishment",
                  reg_no: "Please eneter registration number",
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var params = $("form").serialize();

            $.ajax({
                type: "POST",
                url: endPoint + "settings/company-settings",
                data:params,
                dataType: 'json',
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            $("#transaction_id").val(getTransactionId());
                            showErrorMsg(form, 'success', response['message']);
                        } else {
                            
                            showErrorMsg(form, 'warning', response['message']);
                        }
                    },200);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            getCompanySettings();
            handleCompanySettings();
        }
    };
}();

jQuery(document).ready(function() {
    
    CompanySettings.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
});
