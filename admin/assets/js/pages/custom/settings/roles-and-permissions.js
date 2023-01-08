"use strict";
// Class definition

var GetRolesAndModuleAccessPermissions = function() {

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">\
			'+msg+'\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                <span aria-hidden="true">×</span>\
            </button>\
		</div>');
    }

    // add new role
    var handleNewRole = function() {
        $('#new_role_submit').click(function(e) {
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
                  name: "Please enter role name",
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
                url: endPoint + "settings/new-role",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            //window.location.assign("designations-settings");
                            $('#add_role').modal('hide');
                            $(".transaction_id").val(getTransactionId());
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            handleGetRoles();
                        } else {
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

    // edit role
    var handleEditRole = function() {
        $('#edit_role_submit').click(function(e) {
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
                  name: "Please enter role name",
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
                url: endPoint + "settings/edit-role",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            //window.location.assign("designations-settings");
                            $('#edit_role').modal('hide');
                            $(".transaction_id").val(getTransactionId());
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            handleGetRoles();
                        } else {
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
    var handleDeleteRole = function() {
        $('#delete_role_submit').click(function(e) {
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
                url: endPoint + "settings/delete-role",
                data:formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: { 'Authorization': api_key },
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);

                        if (response['success']) {
                            //window.location.assign("designations-settings");
                            $('#delete_role').modal('hide');
                            $(".transaction_id").val(getTransactionId());
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            handleGetRoles();
                        } else {
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
            handleNewRole();
            handleEditRole();
            handleDeleteRole();
        }
    };
}();

jQuery(document).ready(function() {
    GetRolesAndModuleAccessPermissions.init();
    handleGetRoles();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
});

// fetch all roles
var handleGetRoles = function(current_role_id = 0) {

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
        url: endPoint + 'settings/get-roles',
        data:params,
        dataType: 'json',
        headers: { 'Authorization': api_key },
        // cache:false,
        success:function(response) {
            let all_roles = '';
            if (response['data']) {
                let no = 1;
                let first_role_id = 0;
                $.each(response['data'], function(i, data) { 
                    let active = "";
                    if (no == 1 && current_role_id == 0) {
                        active = 'class="active"';
                        first_role_id = data.id;
                    } else if(current_role_id > 1) {
                        if (current_role_id == data.id) {
                            active = 'class="active"';
                            first_role_id = data.id;
                        }
                    }
                    all_roles += '\
                        <li '+ active +'>\
                            <a href="javascript:handleGetRoles('+ data.id +');">'+ data.name +'\
                                <span class="role-action">\
                                    <span class="action-circle large" data-toggle="modal" data-target="#edit_role" onclick="getRole('+ data.id +')">\
                                        <i class="material-icons">edit</i>\
                                    </span>\
                                    <span class="action-circle large delete-btn" data-toggle="modal" data-target="#delete_role" onclick="getRole('+ data.id +')">\
                                        <i class="material-icons">delete</i>\
                                    </span>\
                                </span>\
                            </a>\
                        </li>\
                    ';
                    no++;
                }); 

                $("#all_roles").empty();
                $("#all_roles").append(all_roles);

                // fetch role module accesses
                getRoleModuleAccess(first_role_id);


            } else {
                $("#all_roles").empty();
            }   
        },
        error: function(error) {
            $("#all_roles").empty();
            console.log(error);
        }
    });        
}

// fetch a role
var getRole = function(id) {

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
		url: endPoint + 'settings/get-roles',
		data:params,
		dataType: 'json',
        headers: { 'Authorization': api_key },
		// cache:false,
		success:function(response) {
			let data = response['data'];
			if (data) {
				$("#edit_name").val(data.name);
				$("#edit_id").val(data.id);
                $("#delete_id").val(data.id);
                $("#transaction_id2").val(getTransactionId());
                $("#transaction_id3").val($("#transaction_id2").val());
			}	
		},
		error: function(error) {
			console.log(error);
		}
	});        
}

// fetch all module permissions
var getModulePermission = function() {

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
        url: endPoint + 'settings/get-module-permissions',
        data:params,
        dataType: 'json',
        headers: { 'Authorization': api_key },
        // cache:false,
        success:function(response) {
            let module_permissions = '<th>Module Permission</th>';
            if (response['data']) {
                $.each(response['data'], function(i, data) { 
                    module_permissions += '\
                        <th class="text-center">'+ data.name +'</th>\
                    ';
                }); 

                $("#module_permissions").empty();
                $("#module_permissions").append(module_permissions);

            } else {
                $("#module_permissions").empty();
            }   
        },
        error: function(error) {
            $("#module_permissions").empty();
            console.log(error);
        }
    });        
}

// fetch module access of a role
var getRoleModuleAccess = function(role_id) {

    // fetch module permissions
    getModulePermission();
    $("#role_module_access_permissions").empty();

    let transaction_id = getTransactionId();
    let employee_id = getCookie("employee_id");
    let user_ses_id = getCookie("user_ses_id");
    let params = {
        "transaction_id": transaction_id,
        "employee_id": employee_id,
        "user_ses_id": user_ses_id,
        "role_id": role_id,
    };

    $.ajax({
        type:'GET',
        url: endPoint + 'settings/get-role-module-access',
        data:params,
        dataType: 'json',
        headers: { 'Authorization': api_key },
        // cache:false,
        success:function(response) {
            let role_module_access = '';
            let role_module_accesses = '';
            if (response['data']) {
                let no = 1;
                let first_role = 0;
                role_module_accesses = response['data'];
                $.each(response['data'], function(i, data) { 
                    let active = "";
                    let checked = "";
                    if (no == 1) {
                        active = 'class="active"';
                        first_role = data.id;
                    }
                    if (data.status == 1) checked = "checked";
                    role_module_access += '\
                        <li class="list-group-item">\
                            '+ data.module_name +'\
                            <div class="status-toggle">\
                                <input type="checkbox" id="module_access_'+data.module_access_id+'" class="check" '+ checked +' onclick="updateRoleModuleAccessStatus('+ data.module_access_id +','+ role_id +')">\
                                <label for="module_access_'+data.module_access_id+'" class="checktoggle">checkbox</label>\
                            </div>\
                        </li>\
                    ';
                    no++;
                    getRoleModuleAccessPermissions(role_id, data.module_access_id, data.module_name);
                }); 

                $("#role_module_access").empty();
                $("#role_module_access").append(role_module_access);

            } else {
                $("#role_module_access").empty();
            }   
        },
        error: function(error) {
            $("#role_module_access").empty();
            console.log(error);
        }
    });        
}

// fetch module permissions of a certain module access of a role
var getRoleModuleAccessPermissions = function(role_id, module_access_id, module_name) {

    let transaction_id = getTransactionId();
    let employee_id = getCookie("employee_id");
    let user_ses_id = getCookie("user_ses_id");
    let params = {
        "transaction_id": transaction_id,
        "employee_id": employee_id,
        "user_ses_id": user_ses_id,
        "role_id": role_id,
        "module_access_id": module_access_id,
    };

    $.ajax({
        type:'GET',
        url: endPoint + 'settings/get-role-module-access-permissions',
        data:params,
        dataType: 'json',
        headers: { 'Authorization': api_key },
        // cache:false,
        success:function(response) {
            let role_module_access_permissions = '\
                <tr>\
                    <td>'+ module_name +'</td>\
            ';

            if (response['data']) {
                let no = 1;
                $.each(response['data'], function(i, data) { 
                    let checked = "";
                    if (data.status == 1) checked = "checked";
                    role_module_access_permissions += '\
                        <td class="text-center">\
                            <input type="checkbox" '+ checked +' onclick="updateRoleModuleAccessPermissionStatus('+ data.module_permission_id + ',' + data.module_access_id +','+ role_id +')">\
                        </td>\
                    ';
                    no++;
                }); 

                role_module_access_permissions += '</tr>';

                $("#role_module_access_permissions").append(role_module_access_permissions);

            }   
        },
        error: function(error) {
            console.log(error);
        }
    });        
}

var updateRoleModuleAccessStatus = function(module_access_id, role_id) {

    let transaction_id = getTransactionId();
    let employee_id = getCookie("employee_id");
    let user_ses_id = getCookie("user_ses_id");
    let params = {
        "transaction_id": transaction_id,
        "employee_id": employee_id,
        "user_ses_id": user_ses_id,
        "role_id": role_id,
        "module_access_id": module_access_id,
    };

    $.ajax({
        type:'POST',
        url: endPoint + 'settings/update-role-module-access-status',
        data:params,
        dataType: 'json',
        headers: { 'Authorization': api_key },
        // cache:false,
        success:function(response) {
            let data = response['data'];
            if (response['success']) {
                // GetLeaveTypes.init();
            }   
        },
        error: function(error) {
            console.log(error);
        }
    });        
}

var updateRoleModuleAccessPermissionStatus = function(module_permission_id, module_access_id, role_id) {

    let transaction_id = getTransactionId();
    let employee_id = getCookie("employee_id");
    let user_ses_id = getCookie("user_ses_id");
    let params = {
        "transaction_id": transaction_id,
        "employee_id": employee_id,
        "user_ses_id": user_ses_id,
        "role_id": role_id,
        "module_access_id": module_access_id,
        "module_permission_id": module_permission_id,
    };

    $.ajax({
        type:'POST',
        url: endPoint + 'settings/update-role-module-access-permission-status',
        data:params,
        dataType: 'json',
        headers: { 'Authorization': api_key },
        // cache:false,
        success:function(response) {
            let data = response['data'];
            if (response['success']) {
                // GetLeaveTypes.init();
            }   
        },
        error: function(error) {
            console.log(error);
        }
    });        
}
