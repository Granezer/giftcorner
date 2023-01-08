"use strict";

var logout = function () { 
	let params = {
		"transaction_id": getTransactionId(),
	};

  	$.ajax({
		type:'POST', 
		url: endPoint + 'users/logout.php',
		data:params,
		// cache:false,
		success:function(response) {
			console.log(response);
			window.location.replace("index");
		}, 
        error: function(error) {
            console.log(error);
            window.location.replace("index");
        }
	});
}