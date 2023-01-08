"use strict";
// Class definition

var KTVerifyEmail = function() {

    var verifyEmail = function() {
	  	var code = $("#code").val();
	  	var token = $("#token").val();

	  	let transaction_id = getTransactionId();
		let params = {
			"transaction_id": transaction_id,
			"code": code,
			"token": token,
		};

		$.ajax({
			type:'GET',
			url: endPoint + 'verify-email',
			data:params,
			dataType: 'json',
			// cache:false,
			success:function(response) {
				if (response['success']) {
                	swal.fire({
                        "title": "Email Verified",
                        "text": "Your email has been successfully verified!",
                        "type": "success",
                        "confirmButtonClass": "btn btn-secondary"
                    });
                      
                } else {
                    swal.fire({
                        "title": "Email Not Verified",
                        "text": response['message'],
                        "type": "warning",
                        "confirmButtonClass": "btn btn-secondary"
                    });
                }
			},
			error: function(error) {
				console.log(error);
				window.location.replace("login");
			}
		});

		setTimeout(function() {
			window.location.replace("login");
		}, 3000);
	}

    // Public Functions
    return {
        // public functions
        init: function() {
            verifyEmail();
        }
    };
}();

jQuery(document).ready(function() {
    KTVerifyEmail.init();;
});
