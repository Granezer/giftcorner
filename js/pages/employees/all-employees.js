"use strict";
// Class definition

var GetEmployees = function() {

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">\
			'+msg+'\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                <span aria-hidden="true">×</span>\
            </button>\
		</div>');
    }

    var handleGetEmployees = function() {

	  	let transaction_id = getTransactionId();
		let employee_id = getCookie("employee_id");
		let user_ses_id = getCookie("user_ses_id");
		let params = {
			"transaction_id": transaction_id,
			"employee_id": employee_id,
			"user_ses_id": user_ses_id,
			"employee_type": "",
		};

		$.ajax({
			type:'GET',
			url: endPoint + 'employees/get-employees',
			data:params,
			dataType: 'json',
			// cache:false,  
			success:function(response) {
				let employees = '';
				if (response['data']) {
                    let no = 1;
					$.each(response['data'], function(i, data) {
						let name = data.first_name +' ' + data.last_name;
						if(data.other_name) name += ' ' + data.other_name; 
						employees += '\
							<tr>\
                                <td>'+ no +'</td>\
								<td>\
									<h2 class="table-avatar">\
										<a href="admin/employees/employee-profile?id='+ data.id +'" class="avatar"><img alt="" src="'+ data.profile_image +'"></a>\
										<a href="admin/employees/employee-profile?id='+ data.id +'">'+ name +' <span>'+ data.designation +'</span></a>\
									</h2>\
								</td>\
								<td>' + data.employee_id_no +'</td>\
								<td>' + data.email +'</td>\
								<td>' + data.phone1 +'</td>\
								<td>' + data.gender +'</td>\
								<td>' + formatDate(data.joined_date, "EEEE, MMMM d, yyyy") +'</td>\
								<td>' + formatDate(data.date_time) +'</td>\
								<td class="text-right">\
									<div class="dropdown dropdown-action">\
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>\
										<div class="dropdown-menu dropdown-menu-right">\
											<a class="dropdown-item" href="admin/employees/employee-profile?id='+ data.id +'"><i class="fa fa-street-view m-r-5"></i> Veiw Details</a>\
											<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a>\
										</div>\
									</div>\
								</td>\
							</tr>\
						';
                        no++;
					});

					$("#employees").empty();
					$("#employees").append(employees);

				} else {
                    checkAccess(response['message']);
					$("#employees").empty();
				}	
			},
			error: function(error) {
				$("#employees").empty();
				console.log(error);
			}
		});        
    }

    // add new employee
    var handleNewEmployee = function() {
        $('#new_employee_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    profile_image_url: 'required',
                    first_name: 'required',
                    last_name: 'required',

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
	                phone1: {
	                    required: true
	                },
	                email: {
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
	                state: {
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

                    joined_date: {
                        required: true,
                    },
                    department: {
                        required: true
                    },
                    designation: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        equalTo: "#password"
                    }
                },
                messages:
                {
                    first_name: "Please enter employee first name",
                    last_name: "Please enter employee last name",
                    profile_image_url: "Please select Profile image",
                    phone1: "Please enter Phone line 1",
                    email: "Please enter a valid email",
                    gender: "Please select gender",
                    marital_status: "Please select marital status",
                    place_of_birth: "Please enter place of birth",
                    dob: "Please select date of birth",
                    address1: "Please enter address line 1",
                    city: "Please enter city",
                    lga: "Please select LGA",
                    state: "Please select state",
                    country: "Please select country",
                    post_code: "Please enter post code",
                    contact_name: "Please enter Next of kin name",
                    contact_phone: "Please enter Next of kin phone",
                    contact_email: "Please enter Next of kin email",
                    contact_address: "Please enter Next of kin address",
                    contact_relationship: "Please enter Next of kin relationship",
                    joined_date: "Please enter date employed",
                    department: "Please select department",
                    designation: "Pleaseselect designation",
                    password:
                        {
                            required: "Password must not be empty",
                            minlength: "Password should be at least 8 characters"
                        },
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
                url: endPoint + "employees/new-employee",
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
                            
                            $('#add_employee').modal('hide');
                            $("#transaction_id1").val(getTransactionId());
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 500);
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },100);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    // edit employee
    var handleEditEmployee = function() {
        $('#edit_employee_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    name: {
                        required: true
                    },
                },
                messages:
                {
                  name: "Please enter employee name",
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
                url: endPoint + "employees/edit-employee",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            //window.location.assign("designations-settings");
                            $('#edit_employee').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 500);
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },100);
                }
            });
        });
    }

    // delete employee
    var handleDeleteEmployee = function() {
        $('#delete_employee_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    id: {
                        required: true
                    },
                },
                messages:
                {
                  id: "ID not found",
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
                url: endPoint + "employees/delete-employee",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            //window.location.assign("designations-settings");
                            $('#delete_employee').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 500);
                        } else {
                            checkAccess(response['message']);
                            swal.fire({
                                "title": "Oops! Error",
                                "text": response['message'],
                                "type": "error",
                                "confirmButtonClass": "btn btn-error"
                            });
                        }
                    },100);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            // handleGetEmployees();
            handleNewEmployee();
        }
    };
}();

jQuery(document).ready(function() {
    GetEmployees.init();
    $("#transaction_id1").val(getTransactionId());
    $("#imageDestination").val(imageDestination);
});