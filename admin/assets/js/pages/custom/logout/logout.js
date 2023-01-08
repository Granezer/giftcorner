"use strict";

var autoLogout = function () { 
	var msg = $("#msg").html();
	var logout = eval($("#logout").html());
	var seconds = eval($("#seconds").html());
	var param = "msg=" + msg;

  	if (logout != 1) return false;

  	$.ajax({
		type:'GET', 
		url: endPoint + 'logout',
		data:param,
		// cache:false,
		success:function(response) {
			console.log(response);
			window.location.replace("login");
		}, 
        error: function(error) {
            console.log(error);
            window.location.replace("login");
        }
	});
}

function logout() {
	$("#logout").html('1');
	autoLogout();
}

jQuery(document).ready(function() {
    autoLogout();
});