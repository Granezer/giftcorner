"use strict";

// Class Definition
var KTEditEmployee = function() {

    var handleUpdateBasicInfo = function() {
        $('#update_employee_basic_info_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    marital_status: {
                        required: true
                    },
                    place_of_birth: {
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
                url: endPoint + "update-employee-basic-info",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Basic Info Updated",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    } else {
                        $(".transaction_id").val(getTransactionId());
                        swal.fire({
                            "title": "Operation Failed",
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

    var handleUpdateContactInfo = function() {
        $('#update_employee_contact_info_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    phone1: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    address1: {
                        required: true
                    },
                    post_code: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    lga: {
                        required: true
                    },
                    state1: {
                        required: true
                    },
                    country: {
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
                url: endPoint + "update-employee-contact-info",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Contact Info Updated",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    } else {
                        $(".transaction_id").val(getTransactionId());
                        swal.fire({
                            "title": "Operation Failed",
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

    var handleUpdateBankInfo = function() {
        $('#update_employee_bank_info_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    bank_name: {
                        required: true
                    },
                    acc_name: {
                        required: true
                    },
                    acc_no: {
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
                url: endPoint + "update-employee-bank-info",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Bank Info Updated",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    } else {
                        $(".transaction_id").val(getTransactionId());
                        swal.fire({
                            "title": "Operation Failed",
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

    var handleUpdateEmergencyInfo = function() {
        $('#update_employee_emergency_info_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    contact_name: {
                        required: true
                    },
                    contact_address: {
                        required: true
                    },
                    contact_phone: {
                        required: true
                    },
                    contact_email: {
                        required: true
                    },
                    contact_relationship: {
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
                url: endPoint + "update-employee-emergency-info",
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        swal.fire({
                            "title": "Next of Kin Info Updated",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    } else {
                        $(".transaction_id").val(getTransactionId());
                        swal.fire({
                            "title": "Operation Failed",
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
            handleUpdateBasicInfo();
            handleUpdateContactInfo();
            handleUpdateEmergencyInfo();
            handleUpdateBankInfo();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTEditEmployee.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
}); 