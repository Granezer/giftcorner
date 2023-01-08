"use strict";
// Class definition

var Roles = function() {
    
    var getRoles = function() {

        var options = $("#roles");
        options.empty();

        var transaction_id = getTransactionId(),
            employee_id = getCookie("employee_id"),
            user_ses_id = getCookie("user_ses_id"),
            params = {
                "transaction_id": transaction_id,
                "employee_id": employee_id,
                "user_ses_id": user_ses_id,
            };

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-roles',
            dataType: 'json',
            data:params,
            headers: { 'Authorization': api_key },
            // cache:false,
            success:function(response) {
                if (response['data']) {
                    let roles = response['data'];
                    options.append(new Option("select role", ''));
                    $.each(roles, function(i, data) {
                        options.append(new Option(data.name, data.id));
                    });
                } 
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    // Public Functions
    return {
        // public functions
        init: function() {
            getRoles();
        }
    };
}();

jQuery(document).ready(function() {
    Roles.init();
});  