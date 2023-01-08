"use strict";
// Class definition

var Departments = function() {
    
    var getDepartments = function() {

        var options = $("#department");
        options.empty();

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-departments',
            dataType: 'json',
            // cache:false,
            success:function(response) {
                if (response['data']) {
                    let departments = response['data'];
                    options.append(new Option('select department', ''));
                    $.each(departments, function(i, data) {
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
            getDepartments();
        }
    };
}();

jQuery(document).ready(function() {
    Departments.init();
});  