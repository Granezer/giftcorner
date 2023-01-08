"use strict";

var wishlist = function(product_id, refresh) {

  let transaction_id = getTransactionId();
	let user_id = getCookie("user_id");
	let user_ses_id = getCookie("user_ses_id");
  let device_id = getCookie("device_id");
	let params = {
		"transaction_id": transaction_id,
		"user_id": user_id,
		"user_ses_id": user_ses_id,
    "device_id": device_id,
		"product_id": product_id,
	};

	$.ajax({
		type:'POST',
		url: endPoint + 'users/wishlist',
		data:params,
		dataType: 'json',
		// cache:false,
		success:function(response) {
			if (response['success']) {
        if (refresh == 1) {
          setTimeout(function() {
            window.location.reload(true);
          },1000);
        } else alert("Operation was successful")
  				
			} else {
        $("#response").html(response['message']);
      }	
		},
		error: function(error) {
			console.log(error);
		}
	});        
}