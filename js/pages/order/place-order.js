"use strict";
var registered_name = '', registered_email = '', registered_phone = '', order_no = '', amount = 0;

// Class Definition
var PlaceOrder = function() {

    var handlePlaceOrder = function() {
        $('#place_order_submit').click(function(e) {
            e.preventDefault();

            var user_id = getCookie("user_id"),
                user_ses_id = getCookie("user_ses_id"),
                shipping_id = $("#shipping_id").val();
            var btn = $(this);
            var form = $(this).closest('form');

            if (!user_id && !user_ses_id) {
                var first_name = $("#first_name").val(),
                    last_name = $("#last_name").val(),
                    fullname = first_name + ' ' + last_name;
                $("#fullname").val(fullname);

                form.validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        phone: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        postcode: {
                            required: true,
                        },
                        city: {
                            required: true,
                        },
                        state: {
                            required: true,
                        },
                        country: {
                            required: true,
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                    },
                    messages:
                    {
                        first_name:
                        {
                          required: "Please enter your first name"
                        },
                        last_name:
                        {
                          required: "Please enter your last name"
                        },
                        phone:
                        {
                          required: "Please enter your phone number"
                        },
                        email:
                        {
                          required: "Please enter your email address"
                        },
                        address:
                        {
                          required: "Please enter your address"
                        },
                        postcode:
                        {
                          required: "Please enter your postcode"
                        },
                        city:
                        {
                          required: "Please enter your city"
                        },
                        state:
                        {
                          required: "Please enter your state"
                        },
                        country:
                        {
                          required: "Please select your country"
                        },
                        password:
                        {
                            required: "Password must not be empty",
                            minlength: "Password should be at least 8 characters"
                        },
                    }
                });

                if (!form.valid()) {
                    return;
                }
                
                // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
                var params = $("form").serialize();

                $.ajax({
                    type: "POST",
                    url: endPoint + "users/registration",
                    data:params,
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        if (response['success']) {
                            $("#transaction_id").val(getTransactionId());
                            registered_name = response.data.fullname;
                            registered_email = response.data.email;
                            registered_phone = response.data.phone;
                            
                            params = $("form").serialize();
                            $.ajax({
                                type: "POST",
                                url: endPoint + "users/shipping-settings.php",
                                data:params,
                                dataType: 'json',
                                success: function(response, status, xhr, $form) {
                                    if (response['success']) {
                                        $("#transaction_id").val(getTransactionId());
                                        $("#shipping_id").val(response['id']);

                                        params = $("form").serialize();
                                        $.ajax({
                                            type: "POST",
                                            url: endPoint + "users/order",
                                            data:params,
                                            dataType: 'json',
                                            success: function(response, status, xhr, $form) {
                                                
                                                if (response['success']) {
                                                    var message = response.message
                                                    response = response.data
                                                    amount = (response.total_amount) * 100;
                                                    order_no = response.order_no;
                                                    var params = "id="+response.order_id + "&reference_no="+response.reference_no+"&code="+response.code
                                                    swal.fire({
                                                        "title": "Success",
                                                        "text": message,
                                                        "type": "success",
                                                        "confirmButtonClass": "btn btn-success"
                                                    });
                                                    setTimeout(function(){
                                                        window.location.assign("order-details?" + params);
                                                    }, 5000)
                                                    // document.getElementById("pay_with_paystack").click();
                                                } else {
                                                    swal.fire({
                                                        "title": "Success",
                                                        "text": response['message'],
                                                        "type": "success",
                                                        "confirmButtonClass": "btn btn-success"
                                                    });
                                                    $("#response").html(response['message']);
                                                }
                                            },
                                            error: function(error) {
                                                console.log(error);
                                            }
                                        });
                                        
                                    } else {
                                        swal.fire({
                                            "title": "Success",
                                            "text": response['message'],
                                            "type": "success",
                                            "confirmButtonClass": "btn btn-success"
                                        });
                                        $("#response").html(response['message']);
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        } else {
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            $("#response").html(response['message']);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else if (!shipping_id || shipping_id == '' || shipping_id == null || shipping_id == undefined) {
                form.validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        phone: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        postcode: {
                            required: true,
                        },
                        city: {
                            required: true,
                        },
                        state: {
                            required: true,
                        },
                        country: {
                            required: true,
                        },
                    },
                    messages:
                    {
                        first_name:
                        {
                          required: "Please enter your first name"
                        },
                        last_name:
                        {
                          required: "Please enter your last name"
                        },
                        phone:
                        {
                          required: "Please enter your phone number"
                        },
                        email:
                        {
                          required: "Please enter your email address"
                        },
                        address:
                        {
                          required: "Please enter your address"
                        },
                        postcode:
                        {
                          required: "Please enter your postcode"
                        },
                        city:
                        {
                          required: "Please enter your city"
                        },
                        state:
                        {
                          required: "Please enter your state"
                        },
                        country:
                        {
                          required: "Please select your country"
                        },
                    }
                });

                if (!form.valid()) {
                    return;
                }

                params = $("form").serialize();

                $.ajax({
                    type: "POST",
                    url: endPoint + "users/shipping-settings.php",
                    data:params,
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        if (response['success']) {
                            $("#shipping_id").val(response['id']);
                            $("#transaction_id").val(getTransactionId());
                            
                            params = $("form").serialize();
                            $.ajax({
                                type: "POST",
                                url: endPoint + "users/order",
                                data:params,
                                dataType: 'json',
                                success: function(response, status, xhr, $form) {
                                    if (response['success']) {
                                        var message = response.message
                                        response = response.data
                                        amount = (response.total_amount) * 100;
                                        order_no = response.order_no;
                                        var params = "id="+response.order_id + "&reference_no="+response.reference_no+"&code="+response.code
                                        swal.fire({
                                            "title": "Success",
                                            "text": message,
                                            "type": "success",
                                            "confirmButtonClass": "btn btn-success"
                                        });
                                        setTimeout(function(){
                                            window.location.assign("order-details?" + params);
                                        }, 5000)
                                        // document.getElementById("pay_with_paystack").click();
                                    } else {
                                        swal.fire({
                                            "title": "Success",
                                            "text": response['message'],
                                            "type": "success",
                                            "confirmButtonClass": "btn btn-success"
                                        });
                                        $("#response").html(response['message']);
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });

                        } else {
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            $("#response").html(response['message']);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                params = $("form").serialize();
                $.ajax({
                    type: "POST",
                    url: endPoint + "users/order",
                    data:params,
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        if (response['success']) {
                            var message = response.message
                            response = response.data
                            amount = (response.total_amount) * 100;
                            order_no = response.order_no;
                            var params = "id="+response.order_id + "&reference_no="+response.reference_no+"&code="+response.code
                            swal.fire({
                                "title": "Success",
                                "text": message,
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            setTimeout(function(){
                                window.location.assign("order-details?" + params);
                            }, 5000)
                            // document.getElementById("pay_with_paystack").click();
                        } else {
                            swal.fire({
                                "title": "Success",
                                "text": response['message'],
                                "type": "success",
                                "confirmButtonClass": "btn btn-success"
                            });
                            $("#response").html(response['message']);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                }); 
            }
        
                
            return false;
        });
    }

    var handleShippingCost = function() {
        $('#calculate_shipping_cost_submit').click(function(e) {
            e.preventDefault();

            var state = $("#shipping_state").val(),
                country = $("#shipping_country").val(),
                shipping_id = $("#shipping_id").val(),
                params = {
                    "state":state,
                    "country":country,
                    "shipping_id":shipping_id
                }

            $.ajax({
                type: "GET",
                url: endPoint + "users/calculate-shipping-cost",
                data:params,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    
                    if (response['success']) {
                        var sub_total = eval($("#sub_total").val());
                        $("#calculated_amount").val("N" + response['data'].amount);
                        $("#calculated-amount").css("display", "block");
                        $("#shipping_cost").html("N" + response['data'].amount);
                        var total = sub_total + eval(response['data'].price);
                        
                        $("#total_amount").html(currencyFormat(total));

                    } else {
                        swal.fire({
                            "title": "Success",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-success"
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    var handlePayWithPaystack = function() {
        $('#pay_with_paystack').click(function(e) {
            e.preventDefault();

            var btn = $("#place_order_submit");
            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
            
            var handler = PaystackPop.setup({ 
                key: paystack_public_key, //put your public key here
                email: registered_email, //put your customer's email here
                amount: amount, //amount the customer is supposed to pay
                firstname: registered_name.split(' ')[0],
                lastname: registered_name.split(' ')[1],
                phone: registered_phone,
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Order No",
                            variable_name: "order_no",
                            value: order_no //created order no
                        }
                    ]
                },
                callback: function (response) {
                    //after the transaction have been completed
                    //make post call  to the server with to verify payment 
                    //using transaction reference as post data
                    var reference_no = response.reference;
                    $.post(endPoint + "verify-payment", {reference:reference_no}, function(response){
                        if(response.data.status == "success") {
                            //successful transaction
                            
                            var transaction_id = getTransactionId(),
                                user_id = getCookie("user_id"),
                                user_ses_id = getCookie("user_ses_id"),
                                params = {
                                    "transaction_id": transaction_id,
                                    "user_id": user_id,
                                    "user_ses_id": user_ses_id,
                                    "order_no": order_no,
                                    "reference_no": reference_no,
                                };
                            $.ajax({
                                type: 'POST',
                                url: endPoint + "users/update-paystack-payment",
                                data: params,
                                dataType: 'json',
                                success: function(response) {
                                    var timeout = 2000;
                                    if(response.success) {
                                        swal.fire({
                                            "title": "Success",
                                            "text": "Your order has been created and your payment was successful",
                                            "type": "success",
                                            "confirmButtonClass": "btn btn-success"
                                        });
                                    } else {
                                        timeout = 5000;
                                        swal.fire({
                                            "title": "Error",
                                            "text": "Your payment was successful but something went wrong. Kindly contact the support team.",
                                            "type": "error",
                                            "confirmButtonClass": "btn btn-success"
                                        });
                                    }
                                    setTimeout(function() {
                                        window.location.assign("order-history");
                                    },timeout);
                                    // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', false);
                                },
                                error: function(error) {
                                    console.log(error);
                                    // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', false);
                                },
                            });
                            
                        } else {
                            // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', false);
                            //transaction failed
                            swal.fire({
                                "title": "Error",
                                "text": response.message,
                                "type": "error",
                                "confirmButtonClass": "btn btn-success"
                            });
                        }
                    });
                },
                onClose: function () {
                    //when the user close the payment modal
                    swal.fire({
                        "title": "Error",
                        "text": "Payment cancelled",
                        "type": "error",
                        "confirmButtonClass": "btn btn-success"
                    });
                    // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', false);

                    setTimeout(function() {
                        window.location.assign("order-history");
                    },1000);
                }
            });
            handler.openIframe(); //open the paystack's payment modal
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handlePlaceOrder();
            handleShippingCost();
            handlePayWithPaystack();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    $("#transaction_id").val(getTransactionId());
    $(".device_id").val(getCookie("device_id"));
    $(".device_name").val(getCookie("device_name"));

    PlaceOrder.init();

    setTimeout( function(){
        var state = $("#state_id").html(),
            country = $("#country_id").html(),
            shippings = $("#shippings").val();

        $('#state option[value="'+state+'"]').prop("selected", "selected").change();
        $('#country option[value="'+country+'"]').prop("selected", "selected").change();

        if (shippings == 1) {
            $("#country").prop('disabled', true);
            $("#state").prop('disabled', true);
            $("#first_name").prop('readonly', true);
            $("#last_name").prop('readonly', true);
            $("#phone").prop('readonly', true);
            $("#email").prop('readonly', true);
            $("#address").prop('readonly', true);
            $("#city").prop('readonly', true);
            $("#postcode").prop('readonly', true);
        }
    }, 500);

    registered_name = $("#registered_name").val();
    registered_email = $("#registered_email").val();
    registered_phone = $("#registered_phone").val();
});