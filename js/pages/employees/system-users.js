"use strict";
// Class definition

var GetSystemUsers = function() {

    var handleNewSystemUser = function() {
        $('#new_system_user_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    id: {
                        required: true
                    },
                    role_id: {
                        required: true
                    },
                },
                messages:
                {
                  id: "Please select employee",
                  role_id: "Please select role",
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
                url: endPoint + "employees/new-system-user",
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
                            //window.location.assign("beds-settings");
                            $('#add_system_user').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 200);
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
                }
            });
        });
    }

    var handleEditSystemUser = function() {
        $('#edit_system_user_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    id: {
                        required: true
                    },
                    role_id: {
                        required: true
                    },
                },
                messages:
                {
                  id: "Please select employee",
                  role_id: "Please select role",
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
                url: endPoint + "employees/edit-system-user",
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
                            //window.location.assign("beds-settings");
                            $('#edit_system_user').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 200);
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
                }
            });
        });
    }

    // delete role
    var handleDeleteSystemUser = function() {
        $('#delete_system_user_submit').click(function(e) {
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
                type: "GET",
                url: endPoint + "employees/delete-system-user",
                data:form.serialize(),
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
                            $('#delete_system_user').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 200);
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
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleNewSystemUser();
            handleEditSystemUser();
            handleDeleteSystemUser();
        }
    };
}();

jQuery(document).ready(function() {
    GetSystemUsers.init();
    $(".transaction_id").val(getTransactionId());
});

var getSystemUser = function(id) {

  	let transaction_id = getTransactionId();
	let employee_id = getCookie("employee_id");
	let user_ses_id = getCookie("user_ses_id");
	let params = {
		"transaction_id": transaction_id,
		"employee_id": employee_id,
		"user_ses_id": user_ses_id,
		"id": id,
	};

	$.ajax({
		type:'GET',
		url: endPoint + 'employees/get-system-users',
		data:params,
		dataType: 'json',
		// cache:false,
		success:function(response) {
            console.log(response);
			let data = response['data'];
			if (data) {
				$("#id").val(data.id);
                $("#eid").val(data.id);
                $("#role_id").val(data.role_id);
			} else {
                checkAccess(response['message']);
            }	
		},
		error: function(error) {
			console.log(error);
		}
	});        
}
