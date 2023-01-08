"use strict";
// Class definition

var Countries = function() {
    
    var getCountries = function() {
        var options = $("#country");
        options.empty();

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-countries',
            dataType: 'json',
            // cache:false,
            success:function(response) {
                options.append(new Option("select country", ''));
                if (response['data']) {
                    $.each(response['data'], function(i, data) {
                        options.append(new Option(data.name, data.id));
                    });
                    setTimeout(function () {
                        $('#country option[value="153"]').prop("selected", "selected").change();
                    }, 1000);
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
            getCountries();
        }
    };
}();

jQuery(document).ready(function() {
    Countries.init();
});
