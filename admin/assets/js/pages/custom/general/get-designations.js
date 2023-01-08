"use strict";
// Class definition

var Designations = function() {
    
    var getDesignations = function() {
        var options = $("#designation");
        options.empty();

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-designations',
            dataType: 'json',
            // cache:false,
            success:function(response) {
                options.append(new Option("select designation", ''));
                if (response['data']) {
                    $.each(response['data'], function(i, data) {
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
            getDesignations();
        }
    };
}();

jQuery(document).ready(function() {
    Designations.init();
});
