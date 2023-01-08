"use strict";

// Class Definition
var Shipping = function() {

    var handleNewShipping = function() {
        $('#new_shipping_address_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    postcode: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                },
                messages:
                {
                  first_name:
                  {
                    required: "Please enter your first name"
                  },
                  last_name:
                  {
                    required: "Please enter your last name"
                  },
                  phone:
                  {
                    required: "Please enter your phone number"
                  },
                  email:
                  {
                    required: "Please enter your email address"
                  },
                  address:
                  {
                    required: "Please enter your address"
                  },
                  postcode:
                  {
                    required: "Please enter your postcode"
                  },
                  city:
                  {
                    required: "Please enter your city"
                  },
                  state:
                  {
                    required: "Please enter your state"
                  },
                  country:
                  {
                    required: "Please select your country"
                  },
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var params = $("form").serialize();
            $.ajax({
                type: "POST",
                url: endPoint + "users/shipping-settings.php",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	$(".transaction_id").val(getTransactionId());
                    $("#response").html(response['message']);
                    if (response['success']) {
                    	// similate 2s delay
	                    setTimeout(function() {
	                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
	                        window.location.assign("shipping-addresses");
	                    },1000);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    var handleEditShipping = function() {
        $('#edit_shipping_address_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
           
            form.validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    postcode: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                },
                messages:
                {
                  first_name:
                  {
                    required: "Please enter your first name"
                  },
                  last_name:
                  {
                    required: "Please enter your last name"
                  },
                  phone:
                  {
                    required: "Please enter your phone number"
                  },
                  email:
                  {
                    required: "Please enter your email address"
                  },
                  address:
                  {
                    required: "Please enter your address"
                  },
                  postcode:
                  {
                    required: "Please enter your postcode"
                  },
                  city:
                  {
                    required: "Please enter your city"
                  },
                  state:
                  {
                    required: "Please enter your state"
                  },
                  country:
                  {
                    required: "Please select your country"
                  },
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', true);
            var params = $("form").serialize();
            $.ajax({
                type: "POST",
                url: endPoint + "users/shipping-settings.php",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                    $(".transaction_id").val(getTransactionId());
                    $("#response").html(response['message']);
                    if (response['success']) {
                    	// similate 2s delay
	                    setTimeout(function() {
	                        // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
	                        window.location.assign("shipping-addresses");
	                    },1000);
                    }
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
            handleNewShipping();
            handleEditShipping();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $(".transaction_id").val(getTransactionId());
    Shipping.init();
});

var setDefaultAddress = function(id) {

  	let transaction_id = getTransactionId();
	let user_id = getCookie("user_id");
	let user_ses_id = getCookie("user_ses_id");
	let params = {
		"transaction_id": transaction_id,
		"user_id": user_id,
		"user_ses_id": user_ses_id,
		"id": id,
	};

	$.ajax({
		type:'POST',
		url: endPoint + 'users/set-default-address',
		data:params,
		dataType: 'json',
		// cache:false,
		success:function(response) {
			if (response['success']) {
				setTimeout(function() {
                    window.location.reload(true);
                },1000);
			} else {
                $("#response").html(response['message']);
            }	
		},
		error: function(error) {
			console.log(error);
		}
	});        
}

var deleteShippingAddress = function(id) {

	if (confirm("Do you want to delete this address?")) {

	  	let transaction_id = getTransactionId();
		let user_id = getCookie("user_id");
		let user_ses_id = getCookie("user_ses_id");
		let params = {
			"transaction_id": transaction_id,
			"user_id": user_id,
			"user_ses_id": user_ses_id,
			"type": "deleted",
			"id": id,
		};

		$.ajax({
			type:'POST',
			url: endPoint + 'users/shipping-settings',
			data:params,
			dataType: 'json',
			// cache:false,
			success:function(response) {
				if (response['success']) {
					setTimeout(function() {
	                    window.location.reload(true);
	                },1000);
				} else {
	                $("#response").html(response['message']);
	            }	
			},
			error: function(error) {
				console.log(error);
			}
		}); 
	}       
}