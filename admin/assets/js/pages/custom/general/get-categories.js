"use strict";
// Class definition

var Catgeories = function() {
    
    var getCatgeories = function() {
        var options = $("#category_id");
        options.empty();

        $.ajax({
            type:'GET',
            url: endPoint + 'get-categories',
            // data:params,
            dataType: 'json',
            // cache:false,
            success:function(response) {
                options.append(new Option("select category", ''));
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
            getCatgeories();
        }
    };
}();

jQuery(document).ready(function() {
    Catgeories.init();
});

document.getElementById("category_id").addEventListener("change", getSubCategories);

function getSubCategories() {
    var param = $("#category_id").val(),
        options = $("#sub_category_id");
    options.empty();
    param = 'category_id=' + param;
 
    $.ajax({
        type:'GET',
        url:endPoint + 'get-sub-categories',
        data:param,
        dataType: 'json',
        // cache:false,
        success:function(response) {
            console.log(response);
            options.append(new Option("select sub categories", ''));
            $.each(response['data'], function(i, d) {
                options.append(new Option(d.sub_name, d.id));
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

    return false;
}

document.getElementById("sub_category_id").addEventListener("change", getSubSubCategories);

function getSubSubCategories() {
    var param = $("#sub_category_id").val(),
        options = $("#sub_sub_category_id");
    options.empty();
    param = 'sub_category_id=' + param;
 
    $.ajax({
        type:'GET',
        url:endPoint + 'get-sub-sub-categories',
        data:param,
        dataType: 'json',
        // cache:false,
        success:function(response) {
            console.log(response);
            options.append(new Option("select sub sub categories", ''));
            $.each(response['data'], function(i, d) {
                options.append(new Option(d.sub_sub_name, d.id));
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

    return false;
}