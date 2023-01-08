"use strict";
// Class definition

var Merchants = function() {
    
    var getMerchants = function() {
        var options = $("#merchant_id");
        options.empty();

        $.ajax({
            type:'GET',
            url: endPoint + 'get-merchants',
            dataType: 'json',
            // cache:false,
            success:function(response) {
                options.append(new Option("select merchant", ''));
                if (response['data']) {
                    $.each(response['data'], function(i, data) {
                        options.append(new Option(data.fullname, data.id));
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
            getMerchants();
        }
    };
}();

jQuery(document).ready(function() {
    Merchants.init();
});