"use strict";

// Class Definition
var Carts = function() {

  var handleGetCarts = function() {
    let transaction_id = getTransactionId();
    let user_id = getCookie("user_id");
    let user_ses_id = getCookie("user_ses_id");
    let device_id = getCookie("device_id");
    let params = {
      "transaction_id": transaction_id,
      "user_id": user_id,
      "user_ses_id": user_ses_id,
      "device_id": device_id,
      "type": "retrieved",
    };

    $.ajax({
      type:'POST',
      url: endPoint + 'users/cart',
      data:params,
      dataType: 'json',
      // cache:false,
      success:function(response) {
        console.log(response);
        if (response['success']) {
          var details = response['details']
          $(".cart-amunt").html("N" + details.total_amount);
          $(".product-count").html(details.total_cart_items);
          if (details.total_cart_items > 0) $("#checkout_link").css("display", "block");
          else $("#checkout_link").css("display", "none");
        } 
      },
      error: function(error) {
        console.log(error);
      }
    }); 
  }

  var handleUpdateCarts = function() {
    $('#update_cart_submit').click(function(e) {
        e.preventDefault();

        var btn = $(this);
        var form = $(this).closest('form');

        form.validate({
            rules: {
                product_ids: {
                    required: true
                },
            },
        });

        if (!form.valid()) {
            return;
        }

        // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', true);
        var params = $("form").serialize();

        $.ajax({
            type: "POST",
            url: endPoint + "users/cart",
            data:params,
            dataType: 'json',
            success: function(response, status, xhr, $form) {
              console.log(response);
              if (response['success']) {
                swal.fire({
                    "title": "Success",
                    "text": "Cart Item(s) updated successfully",
                    "type": "success",
                    "confirmButtonClass": "btn btn-success"
                });
                // similate 2s delay
                setTimeout(function() {
                    // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--dark').attr('disabled', false);
                    window.location.reload(true);
                },1000);

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

  var handleApplyCoupon = function() {
    $('#apply_coupon_submit').click(function(e) {
        e.preventDefault();
          return false;
      });
  }

  // Public Functions
  return {
      // public functions
      init: function() {
          handleGetCarts();
          handleUpdateCarts();
          handleApplyCoupon();
      }
  };
}();

// Class Initialization
jQuery(document).ready(function() {
    $(".transaction_id").val(getTransactionId());
    $(".user_id").val(getCookie("user_id"));
    $(".user_ses_id").val(getCookie("user_ses_id"));
    $(".device_id").val(getCookie("device_id"));
    Carts.init();
});

var addCart = function() {
  var qty = $("#qty").val(),
    product_id = $("#product_id").val();

  cart(product_id, qty);

  return false;
}

var addItemToCartFromAnyWhere = function(product_id) {
  var qty = 1;
  cart(product_id, qty);

  return false;
}

var cart = function(product_id, qty) {

  let transaction_id = getTransactionId();
	let user_id = getCookie("user_id");
	let user_ses_id = getCookie("user_ses_id");
  let device_id = getCookie("device_id");
	let params = {
		"transaction_id": transaction_id,
		"user_id": user_id,
		"user_ses_id": user_ses_id,
    "device_id": device_id,
    "type": "add",
		"product_id": product_id,
    "qty": qty,
	};

	$.ajax({
		type:'POST',
		url: endPoint + 'users/cart',
		data:params,
		dataType: 'json',
		// cache:false,
		success:function(response) {
      console.log(response);
			if (response['success']) {
        var details = response['details']
        $(".cart-amunt").html("N" + details.total_amount);
        $(".product-count").html(details.total_cart_items);
        if (details.total_cart_items > 0) $("#checkout_link").css("display", "block");
        else $("#checkout_link").css("display", "none");

        swal.fire({
            title: "Item Added",
            text: "Item successfully added to cart",
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#34bfa3',
            cancelButtonColor: '#ffb822',
            cancelButtonText: 'Continue shopping',
            confirmButtonText: 'Checkout'
        }).then((result) => {
            if (result.value) {
                // call function
                window.location.assign("checkout");
            } else {
                
            }
        });

			} else console.log(response['message']);
		},
		error: function(error) {
			console.log(error);
		}
	}); 

  return false;       
}

var increaseQty = function(id) {
  var qty = eval($("#qty" + id).val());
  qty = qty + 1;
  $("#qty" + id).val(qty);

  return false;
}

var decreaseQty = function(id) {
  var qty = eval($("#qty" + id).val());

  if (qty <= 0) {
    $("#qty" + id).val(0);
    return false;
  }

  qty = qty - 1;
  $("#qty" + id).val(qty);

  return false;
}

var moveItem = function(product_id, type) {

  let transaction_id = getTransactionId();
  let user_id = getCookie("user_id");
  let user_ses_id = getCookie("user_ses_id");
  let device_id = getCookie("device_id");
  let params = {
    "transaction_id": transaction_id,
    "user_id": user_id,
    "user_ses_id": user_ses_id,
    "device_id": device_id,
    "type": type,
    "product_id": product_id,
  };

  $.ajax({
    type:'POST',
    url: endPoint + 'users/cart',
    data:params,
    dataType: 'json',
    // cache:false,
    success:function(response) {
      console.log(response);
      if (response['success']) {
        var details = response['details']
        $(".cart-amunt").html("N" + details.total_amount);
        $(".product-count").html(details.total_cart_items);

        swal.fire({
            "title": "Success",
            "text": "Item moved",
            "type": "success",
            "confirmButtonClass": "btn btn-success"
        });
        window.location.reload(true);

      } else console.log(response['message']);
    },
    error: function(error) {
      console.log(error);
    }
  }); 

  return false;       
}

var removeItemFromCart = function(product_id) {

  let transaction_id = getTransactionId();
  let user_id = getCookie("user_id");
  let user_ses_id = getCookie("user_ses_id");
  let device_id = getCookie("device_id");
  let params = {
    "transaction_id": transaction_id,
    "user_id": user_id,
    "user_ses_id": user_ses_id,
    "device_id": device_id,
    "type": "deleted",
    "product_id": product_id,
  };

  $.ajax({
    type:'POST',
    url: endPoint + 'users/cart',
    data:params,
    dataType: 'json',
    // cache:false,
    success:function(response) {
      console.log(response);
      if (response['success']) {
        var details = response['details']
        $(".cart-amunt").html("N" + details.total_amount);
        $(".product-count").html(details.total_cart_items);
        if (details.total_cart_items > 0) $("#checkout_link").css("display", "block");
        else $("#checkout_link").css("display", "none");

        swal.fire({
            "title": "Success",
            "text": "Item removed",
            "type": "success",
            "confirmButtonClass": "btn btn-success"
        });
        swal.fire({
            title: "Item Removed",
            text: "Item successfully removed from cart",
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#34bfa3',
            cancelButtonColor: '#ffb822',
            cancelButtonText: 'Continue shopping',
            confirmButtonText: 'Checkout'
        }).then((result) => {
            if (result.value) {
                // call function
                window.location.assign("checkout");
            } else {
                window.location.reload(true);
            }
        });

      } else console.log(response['message']);
    },
    error: function(error) {
      console.log(error);
    }
  }); 

  return false;       
}