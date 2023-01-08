"use strict";
// Class definition

var Product = function() {
    
    var getProduct = function() {
        var transaction_id = getTransactionId(),
            employee_id = getCookie("employee_id"),
            user_ses_id = getCookie("user_ses_id"),
            params = {
                "transaction_id": transaction_id,
                "employee_id": employee_id,
                "user_ses_id": user_ses_id,
                "id": $("#id").val(),
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
                        
                    $("#id").val(data.id);
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

                    var images = '',
                        n = 0;
                    data.image_urls = (data.image_urls).split('|');
                    $.each(data.image_urls, function(i, d) {
                        n++;
                        var e = [];
                        e[0] = data.id;
                        e[1] = n;
                        
                        var image_exts = ["jpg", "jpeg", "png", "gif"],
                            file_ext = get_file_ext(d);

                        if (image_exts.includes(file_ext)) {
                            images +='\
                            <a href="javascript:void(0)" onclick="return deleteProductImage('+ e +')" class="kt-media" style="cusor:pointer;">\
                                <img alt="Product image" src="assets/media/products/'+ d +'" style="height: 80px; width: 80px" />\
                            </a>&nbsp;';
                        } else {
                            images +='\
                            <a href="javascript:void(0)" onclick="return deleteProductImage('+ e +')" class="kt-media" style="cusor:pointer;">\
                                <video style="height: 30px;" controls>\
                                    <source src="assets/media/products/' + d + '" type="video/'+ file_ext +'">\
                                </video>\
                            </a>&nbsp;';
                        }
                    });

                    if (images) {
                        $("#images").html(images);
                        $("#images").css("display", "block");
                    }

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
            getProduct();
        }
    };
}();

jQuery(document).ready(function() {
    Product.init();
});

function deleteProductImage(id, index) {
    var params = {
        "id": id,
        "index": index
    };

    $.ajax({
        type:'POST',
        url:endPoint + 'delete-product-images',
        data:params,
        dataType: 'json',
        // cache:false,
        success:function(response) {
            if (response.success) {
                let data = response.data;
                var images = '',
                    n = 0;
                data.image_urls = (data.image_urls).split('|');
                $.each(data.image_urls, function(i, d) {
                    n++;
                    var e = [];
                    e[0] = data.id;
                    e[1] = n; 
                    images +='\
                        <a href="javascript:void(0)" onclick="return deleteProductImage('+e+')" class="kt-media">\
                            <img alt="Product image" src="assets/media/products/'+ d +'" style="height: 80px; width: 80px" />\
                        </a>&nbsp;';
                });

                if (images) {
                    $("#images").html(images);
                    $("#images").css("display", "block");
                } else $("#images").css("display", "none");
            } else {
                swal.fire({
                    "title": "Error",
                    "text": response['message'],
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
            } 
                
        },
        error: function(error) {
            console.log(error);
        }
    });

    return false;
}