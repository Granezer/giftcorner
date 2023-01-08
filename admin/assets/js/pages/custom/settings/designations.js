"use strict";
// Class definition

var GetDesignations = function() {

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">\
			'+msg+'\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                <span aria-hidden="true">×</span>\
            </button>\
		</div>');
    }

    var handleGetDesignations = function() {

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
			url: endPoint + 'settings/get-designations',
			data:params,
			dataType: 'json',
            headers: { 'Authorization': api_key },
			// cache:false,
			success:function(response) {
				let designations = '';
				if (response['data']) {
					let no = 1;
					$.each(response['data'], function(i, data) { 
						designations += '\
							<tr>\
								<td>' + no +'</td>\
								<td>' + data.name +'</td>\
								<td>' + formatDate(data.date_time) +'</td>\
								<td class="text-right">\
									<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_designation" onclick="getDesignation('+ data.id +')"><i class="fa fa-pencil m-r-5"></i> </a>\
								</td>\
							</tr>\
						';
						no++;
					});

					$("#designations").empty();
					$("#designations").append(designations);

				} else {
                    checkAccess(response['message']);
					$("#designations").empty();
				}	
			},
			error: function(error) {
				$("#designations").empty();
				console.log(error);
			}
		});        
    }

    var handleNewDesignation = function() {
        $('#new_designation_submit').click(function(e) {
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
                  name: "Please enter designation name",
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
                url: endPoint + "settings/new-designation",
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
                            $('#add_designation').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            handleGetDesignations();
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

    var handleEditDesignation = function() {
        $('#edit_designation_submit').click(function(e) {
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
                  name: "Please enter designation name",
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
                url: endPoint + "settings/edit-designation",
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
                            $('#edit_designation').modal('hide');
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            handleGetDesignations();
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
            handleGetDesignations();
            handleNewDesignation();
            handleEditDesignation();
        }
    };
}();

jQuery(document).ready(function() {
    GetDesignations.init();
    $(".transaction_id").val(getTransactionId());
    $(".employee_id").val(getCookie("employee_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
});

// $("#edit_designation").on('shown.bs.modal', function() { 
//     // $('#edit_designation').modal('show');
//     alert('shown');
// });

var getDesignation = function(id) {

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
		url: endPoint + 'settings/get-designation-by-id',
		data:params,
		dataType: 'json',
        headers: { 'Authorization': api_key },
		// cache:false,
		success:function(response) {
			let data = response['data'];
			if (data) {
				$("#edit_name").val(data.name);
				$("#edit_id").val(data.id);
			} else {
                checkAccess(response['message']);
            }	
		},
		error: function(error) {
			console.log(error);
		}
	});        
}
