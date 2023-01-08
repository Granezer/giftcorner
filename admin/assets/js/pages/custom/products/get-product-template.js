"use strict";
// Class definition

var ProductTemplate = function() {
    
    var getProductTemplate = function() {
        var transaction_id = getTransactionId(),
            employee_id = getCookie("employee_id"),
            user_ses_id = getCookie("user_ses_id"),
            params = {
                "transaction_id": transaction_id,
                "employee_id": employee_id,
                "user_ses_id": user_ses_id,
                "id": $("#template").val(),
            };

        $.ajax({
            type:'GET',
            url: endPoint + 'get-products',
            data:params,
            dataType: 'json',
            // cache:false,
            success:function(response) {
                console.log(response)
                var data = response.data;
                if (data) {
                    $("#name").val(data.name);
                    $("#price").val(data.price);
                    $("#short_desc").val(data.short_desc);
                    $("#description").val(data.description);                    
                    $("#product_off").val(data.product_off);
                    $("#discount_start_date").val(data.discount_start_date);
                    $("#discount_end_date").val(data.discount_end_date);
                    $("#weight").val(data.weight);
                    $("#breadth").val(data.breadth);
                    $("#length").val(data.length);
                    $("#depth").val(data.depth);

                }  else {
                    // checkAccess(response['message']);
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
            getProductTemplate();
        }
    };
}();

jQuery(document).ready(function() {
    ProductTemplate.init();
});