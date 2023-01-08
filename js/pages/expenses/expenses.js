"use strict";
// Class definition

var GetExpenses = function() {

    var handleNewExpenses = function() {
        $('#new_expenses_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    type_id: {
                        required: true
                    },
                    amount: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    date_of_expenses: {
                        required: true
                    },
                },
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
                url: endPoint + "expenses/new-expenses",
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
                            $('#add_expenses').modal('hide');
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

    var handleEditExpenses = function() {
        $('#edit_expenses_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    type_id: {
                        required: true
                    },
                    amount: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    date_of_expenses: {
                        required: true
                    },
                },
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
                url: endPoint + "expenses/edit-expenses",
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
                            $('#edit_expenses').modal('hide');
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
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    // delete role
    var handleDeleteExpenses = function() {
        $('#delete_expenses_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    id: {
                        required: true
                    },
                },
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
                url: endPoint + "expenses/delete-expenses",
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
                            $('#delete_expenses').modal('hide');
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
            handleNewExpenses();
            handleEditExpenses();
            handleDeleteExpenses();
        }
    };
}();

jQuery(document).ready(function() {
    GetExpenses.init();
    $(".transaction_id").val(getTransactionId());
});

var getExpenses = function(id) {

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
		url: endPoint + 'expenses/get-expenses',
		data:params,
		dataType: 'json',
		// cache:false,
		success:function(response) {
			let data = response['data'];
			if (data) {
				$("#type_id").val(data.type_id);
                $("#description").val(data.description);
				$("#amount").val(data.amount);
                $("#date_of_expenses").val(data.date_of_expenses);
                $(".id").val(data.id);
			} else {
                checkAccess(response['message']);
            }	
		},
		error: function(error) {
			console.log(error);
		}
	});        
}
