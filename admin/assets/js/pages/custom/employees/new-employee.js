"use strict";

// Class definition
var KTWizard2 = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var validator;
    var wizard;

    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        wizard = new KTWizard('kt_wizard_v2', {
            startStep: 1, // initial active step number
            clickableSteps: true  // allow step clicking
        });

        // Validation before going to next page
        wizard.on('beforeNext', function(wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        });

        wizard.on('beforePrev', function(wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        });

        // Change event
        wizard.on('change', function(wizard) {
            KTUtil.scrollTop();
        });
    }

    var initValidation = function() {
        validator = formEl.validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Validation rules
            rules: {
                //= Step 1
                profile_image: {
                    required: true
                },
                title: {
                    required: true
                },
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
                dob: {
                    required: true
                },
                place_of_birth: {
                    required: true
                },

                // = Step 2
                phone1: {
                    required: true
                },
                emaul: {
                    required: true,
                    email: true
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
                state1: {
                    required: true
                },
                lga: {
                    required: true
                },
                country: {
                    required: true
                },

                //= Step 3
                contact_name: {
                    required: true
                },
                contact_phone: {
                    required: true,
                },
                contact_email: {
                    required: true,
                    email: true
                },
                contact_address: {
                    required: true
                },
                contact_relationship: {
                    required: true,
                },

                //= Step 4
                joined_date: {
                    required: true
                },
                bank_name: {
                    required: true
                },
                acc_name: {
                    required: true,
                },
                acc_no: {
                    required: true
                },
            },

            // Display error
            invalidHandler: function(event, validator) {
                KTUtil.scrollTop();
            },

            // Submit valid form
            submitHandler: function (form) {

            }
        });
    }

    var initSubmit = function() {
        var btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function(e) {
            e.preventDefault();

            if (validator.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                //KTApp.block(formEl);

                // See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                    type: "POST",
                    url: endPoint + "new-employee.php",
                    success: function(response) {
                        KTApp.unprogress(btn);
                        //KTApp.unblock(formEl);

                        if (response['success']) {
                            // window.location.replace("");
                            swal.fire({
                                "title": "Employee Added Successfully",
                                "text": "Password: " + response['password'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-secondary"
                            });

                            setTimeout(function() {
                                window.location.replace("employees/");
                                }, 
                                10000
                            );
                        } else {
                            swal.fire({
                                "title": "Opps! Error Occurred",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-secondary"
                            });
                        }
                    }, error: function (error) {
                        KTApp.unprogress(btn);
                        console.log(error);
                    }
                });
            }
        });
    }

    return {
        // public functions
        init: function() {
            wizardEl = KTUtil.get('kt_wizard_v2');
            formEl = $('#kt_form');

            initWizard();
            initValidation();
            initSubmit();
        }
    };
}();

jQuery(document).ready(function() {
    KTWizard2.init();
    $(".transaction_id").val(getTransactionId()); 
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
    $("#imageDestination").val(imageDestination);
});
