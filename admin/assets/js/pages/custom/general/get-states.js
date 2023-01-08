"use strict";
// Class definition

var States = function() {
    
    var getStates = function() {
        var options = $("#state1");
        options.empty();

        $.ajax({
            type:'GET',
            url: endPoint + 'settings/get-states',
            // data:params,
            dataType: 'json',
            // cache:false,
            success:function(response) {
                options.append(new Option("select state", ''));
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
            getStates();
        }
    };
}();

jQuery(document).ready(function() {
    States.init();
});

document.getElementById("state1").addEventListener("change", getLGAs);

function getLGAs() {
    var param = $("#state1").val(),
        options = $("#lga");
    options.empty();
    param = 'state=' + param;
 
    $.ajax({
        type:'GET',
        url:endPoint + 'settings/get-lgas-by-state',
        data:param,
        dataType: 'json',
        // cache:false,
        success:function(response) {
            console.log(response);
            options.append(new Option("select lga", ''));
            $.each(response['data'], function(i, d) {
                options.append(new Option(d.name, d.id));
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

    return false;
  
}