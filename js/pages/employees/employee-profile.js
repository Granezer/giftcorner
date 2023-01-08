"use strict";
// Class definition

var GetEmployeDetails = function() {
    
    var getGetEmployeDetails = function() {

        var url_params = getUrlParams();

        let transaction_id = getTransactionId();
        let employee_id = getCookie("employee_id");
        let user_ses_id = getCookie("user_ses_id");

        let params = {
            "transaction_id": transaction_id,
            "employee_id": employee_id,
            "user_ses_id": user_ses_id,
            "id": url_params.id,
        };

        $.ajax({
            type:'GET',
            url: endPoint + 'employees/get-employees',
            data:params,
            dataType: 'json',
            // cache:false,
            success:function(response) {
                if (response['data']) {
                    let employee = response['data'];
                    console.log(employee);
                    $(".employee_id").val(employee.id);

                    var image = new Image();
                    image.src = employee.profile_image;

                    image.onload = function() {
                        // image exists and is loaded
                        $(".profile_image").html('<img alt="" src="'+ employee.profile_image +'">');
                        $(".profile_image_url").attr("src", employee.profile_image);
                    }
                    image.onerror = function() {
                        // image did not load
                        // do nothing
                    }
                    

                    // profile details
                    // $(".profile_image").html('<img alt="" src="'+ checkImage(employee.profile_image, function(){ employee.profile_image; return true; }, function(){ employee.profile_image = ""; return false; } ) +'"></a>');
                    let name = employee.first_name + ' ' + employee.last_name;
                    if (employee.other_name) name += ' ' + employee.other_name;

                    $(".name").html(name);
                    $(".designations").html(employee.designation);
                    $(".employee_id_no").html('Employee ID : ' + employee.employee_id_no);
                    $(".joined_date").html('Date of Join : ' + formatDate(employee.joined_date, "EEEE, MMMM d, yyyy"));
                    $(".gender").html(employee.gender);
                    $(".phone1").html(employee.phone1);
                    $(".email").html(employee.email);
                    $(".address1").html(employee.address1);
                    $(".dob").html(formatDate(employee.dob, "EEEE, MMMM d, yyyy"));

                    
                    $("#first_name").val(employee.first_name);
                    $("#last_name").val(employee.last_name);
                    $("#other_name").val(employee.other_name);
                    $("#gender").val(employee.gender);
                    $("#phone1").val(employee.phone1);
                    $("#email").val(employee.email);
                    $("#address1").val(employee.address1);
                    $("#dob").val(employee.dob);
                    $("#joined_date").val(employee.joined_date);
                    setTimeout(function () {
                        $('#designation option[value="'+employee.designation_id+'"]').prop("selected", "selected").change();
                        $('#department option[value="'+employee.department_id+'"]').prop("selected", "selected").change();
                    }, 500);

                    $(".post_code").html(employee.post_code);
                    $(".state").html(employee.state);
                    $(".lga").html(employee.lga);
                    $(".religion").html(employee.religion);
                    $(".phone2").html(employee.phone2);
                    $(".country").html(employee.nationality);
                    $(".address2").html(employee.address2);
                    $(".place_of_birth").html(employee.place_of_birth);
                    $(".no_of_children").html(employee.no_of_children);
                    $(".no_of_spouse").html(employee.no_of_spouse);
                    $(".marital_status").html(employee.marital_status);

                    $("#post_code").val(employee.post_code);
                    $("#religion").val(employee.religion);
                    $("#phone2").val(employee.phone2);
                    $("#address2").val(employee.address2);
                    $("#place_of_birth").val(employee.place_of_birth);
                    $("#city").val(employee.city);
                    $("#no_of_children").val(employee.no_of_children);
                    $("#no_of_spouse").val(employee.no_of_spouse);
                    $("#marital_status").val(employee.marital_status);

                    setTimeout(function () {
                        $('#state option[value="'+employee.state_id+'"]').prop("selected", "selected").change();
                        $('#country option[value="'+employee.country+'"]').prop("selected", "selected").change();
                        getLGAs();
                    }, 100);

                    setTimeout(function () {
                        $("#lga").val(employee.lga_id);
                    }, 500);

                    // next of kin details
                    $(".contact_name").html(employee.contact_name);
                    $(".contact_phone").html(employee.contact_phone);
                    $(".contact_email").html(employee.contact_email);
                    $(".contact_address").html(employee.contact_address);
                    $(".contact_relationship").html(employee.contact_relationship);

                    $("#contact_name").val(employee.contact_name);
                    $("#contact_phone").val(employee.contact_phone);
                    $("#contact_email").val(employee.contact_email);
                    $("#contact_address").val(employee.contact_address);
                    $("#contact_relationship").val(employee.contact_relationship);

                    // bank details
                    $(".bank_name").html(employee.bank_name);
                    $(".acc_name").html(employee.acc_name);
                    $(".acc_no").html(employee.acc_no);

                    $("#bank_name").val(employee.bank_name);
                    $("#acc_name").val(employee.acc_name);
                    $("#acc_no").val(employee.acc_no);
                } else {
                    checkAccess(response['message']);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // add new employee
    var handleUpdateProfile = function() {
        $('#update_profile_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    first_name: 'required',
                    last_name: 'required',
                    gender: 'required',
                    phone1: 'required',
                    email: 'required',
                    address1: 'required',
                    dob: 'required',
                    joined_date: 'required',
                    designation: 'required',
                    department: 'required',
                },
                messages:
                {
                    first_name: "Please enter employee first name",
                    last_name: "Please enter employee last name",
                    gender: "Please select employee gender",
                    phone1: "Please enter employee phone line 1",
                    email: "Please enter employee email",
                    address1: "Please enter employee address line 1",
                    dob: "Please enter employee date of birth",
                    joined_date: "Please enter employee date of employment",
                    designation: "Please select employee designation",
                    department: "Please select employee department",
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            $.ajax({
                type: "POST",
                url: endPoint + "employees/edit-employee-profile",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            
                            $(".transaction_id").val(getTransactionId());
                            let employee = response['data'];
                            // next of kin details

                            let name = employee.first_name + ' ' + employee.last_name;
                            if (employee.other_name) name += ' ' + employee.other_name;

                            $(".name").html(name);
                            $(".designations").html(employee.designation);
                            $(".employee_id_no").html('Employee ID : ' + employee.employee_id_no);
                            $(".joined_date").html('Date of Join : ' + formatDate(employee.joined_date, "EEEE, MMMM d, yyyy"));
                            $(".gender").html(employee.gender);
                            $(".phone1").html(employee.phone1);
                            $(".email").html(employee.email);
                            $(".address1").html(employee.address1);
                            $(".dob").html(formatDate(employee.dob, "EEEE, MMMM d, yyyy"));

                            var image = new Image();
                            image.src = employee.profile_image;

                            image.onload = function() {
                                // image exists and is loaded
                                $(".profile_image").html('<img alt="" src="'+ employee.profile_image +'">');
                                $(".profile_image_url").attr("src", employee.profile_image);
                            }
                            image.onerror = function() {
                                // image did not load
                                // do nothing
                            }
                            
                            $("#first_name").val(employee.first_name);
                            $("#last_name").val(employee.last_name);
                            $("#other_name").val(employee.other_name);
                            $("#gender").val(employee.gender);
                            $("#phone1").val(employee.phone1);
                            $("#email").val(employee.email);
                            $("#address1").val(employee.address1);
                            $("#dob").val(employee.dob);
                            $("#joined_date").val(employee.joined_date);
                            $("#department").val(employee.department_id);
                            $("#designation").val(employee.designation_id);

                            $('#profile_info').modal('hide');

                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },200);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    // add new employee
    var handleUpdatePersonalInfo = function() {
        $('#update_personal_info_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    post_code: 'required',
                    marital_status: 'required',
                    state: 'required',
                    city: 'required',
                    country: 'required',
                    lga: 'required',
                },
                messages:
                {
                    post_code: "Please enter employee postal code",
                    marital_status: "Please select employee marital status",
                    state: "Please select employee state",
                    city: "Please enter employee city",
                    country: "Please enter employee country",
                    lga: "Please select employee lga",
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            $.ajax({
                type: "POST",
                url: endPoint + "employees/edit-employee-personal-info",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            
                            $(".transaction_id").val(getTransactionId());
                            let employee = response['data'];
                            // personal details
                            $(".post_code").html(employee.post_code);
                            $(".state").html(employee.state);
                            $(".lga").html(employee.lga);
                            $(".religion").html(employee.religion);
                            $(".phone2").html(employee.phone2);
                            $(".country").html(employee.nationality);
                            $(".address2").html(employee.address2);
                            $(".place_of_birth").html(employee.place_of_birth);
                            $(".no_of_children").html(employee.no_of_children);
                            $(".no_of_spouse").html(employee.no_of_spouse);
                            $(".marital_status").html(employee.marital_status);

                            $("#post_code").val(employee.post_code);
                            $("#religion").val(employee.religion);
                            $("#phone2").val(employee.phone2);
                            $("#address2").val(employee.address2);
                            $("#place_of_birth").val(employee.place_of_birth);
                            $("#city").val(employee.city);
                            $("#no_of_children").val(employee.no_of_children);
                            $("#no_of_spouse").val(employee.no_of_spouse);
                            $("#marital_status").val(employee.marital_status);

                            setTimeout(function () {
                                $('#state option[value="'+employee.state_id+'"]').prop("selected", "selected").change();
                                $('#country option[value="'+employee.country+'"]').prop("selected", "selected").change();
                                getLGAs();
                            }, 100);

                            setTimeout(function () {
                                $("#lga").val(employee.lga_id);
                            }, 500);

                            $('#personal_info_modal').modal('hide');

                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },200);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    // add new employee
    var handleUpdateBank = function() {
        $('#bank_details_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    bank_name: 'required',
                    acc_name: 'required',
                    acc_no: 'required',
                },
                messages:
                {
                    bank_name: "Please enter bank name",
                    acc_name: "Please enter account name",
                    acc_no: "Please enter account no",
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            $.ajax({
                type: "POST",
                url: endPoint + "employees/edit-bank",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            
                            $(".transaction_id").val(getTransactionId());
                            let employee = response['data'];
                            $(".bank_name").html(employee.bank_name);
                            $(".acc_name").html(employee.acc_name);
                            $(".acc_no").html(employee.acc_no);

                            $("#bank_name").val(employee.bank_name);
                            $("#acc_name").val(employee.acc_name);
                            $("#acc_no").val(employee.acc_no);

                            $('#bank_info_modal').modal('hide');

                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },200);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    // add new employee
    var handleUpdateNextOfKin = function() {
        $('#update_next_of_kin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    contact_name: 'required',
                    contact_phone: 'required',
                    contact_email: 'required',
                    contact_address: 'required',
                    contact_relationship: 'required',
                },
                messages:
                {
                    contact_name: "Please enter next of kin name",
                    contact_phone: "Please enter next of kin phone",
                    contact_email: "Please enter next of kin email",
                    contact_address: "Please enter next of kin address",
                    contact_relationship: "Please enter next of kin relationship",
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            $.ajax({
                type: "POST",
                url: endPoint + "employees/edit-next-of-kin",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    console.log(response);
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            
                            $(".transaction_id").val(getTransactionId());
                            let employee = response['data'];
                            // next of kin details
                            $(".contact_name").html(employee.contact_name);
                            $(".contact_phone").html(employee.contact_phone);
                            $(".contact_email").html(employee.contact_email);
                            $(".contact_address").html(employee.contact_address);
                            $(".contact_relationship").html(employee.contact_relationship);

                            $("#contact_name").val(employee.contact_name);
                            $("#contact_phone").val(employee.contact_phone);
                            $("#contact_email").val(employee.contact_email);
                            $("#contact_address").val(employee.contact_address);
                            $("#contact_relationship").val(employee.contact_relationship);

                            $('#next_of_kin_modal').modal('hide');

                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },200);
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
            getGetEmployeDetails();
            handleUpdateProfile();
            handleUpdatePersonalInfo();
            handleUpdateBank();
            handleUpdateNextOfKin();
        }
    };
}();

jQuery(document).ready(function() {
    GetEmployeDetails.init();
    $(".transaction_id").val(getTransactionId());
    $("#imageDestination").val(imageDestination);
});  