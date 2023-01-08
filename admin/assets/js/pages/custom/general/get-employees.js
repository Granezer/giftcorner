"use strict";
// Class definition

var Employees = function() {
    
    var getEmployees = function() {
        var options = $("#employees");
        options.empty();

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
            url: endPoint + 'get-employees',
            data:params,
            dataType: 'json',
            headers: { 'Authorization': api_key },
            // cache:false,
            success:function(response) {
                options.append(new Option("select employee", ''));
                if (response['data']) {
                    $.each(response['data'], function(i, data) {
                        options.append(new Option(data.title + ' ' + data.fullname + ' ('+data.employee_id_no+')', data.id));
                    });
                    all_employees = response['data'];
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
            getEmployees();
        }
    };
}();

jQuery(document).ready(function() {
    Employees.init();
});
