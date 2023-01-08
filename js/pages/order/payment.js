"use strict";

// Class Initialization
jQuery(document).ready(function() {
    $(".transaction_id").val(getTransactionId());
});

$("#pay_with_paystack_submit").on("click", function(){

  var btn = $(this);
  var amount = eval($("#amount_to_pay").val()),
    order_no = $("#order_no").val(),
    registered_email = $("#registered_email").val(),
    registered_name = $("#registered_name").val(),
    registered_phone = $("#registered_phone").val();

  if (amount <= 0) {
      return;
  }

  amount = amount * 100;

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
                                  "text": "Your payment was successful",
                                  "type": "success",
                                  "confirmButtonClass": "btn btn-success"
                              });
                          } else {
                              timeout = 5000;
                              swal.fire({
                                  "title": "Success",
                                  "text": "Your payment was successful but something went wrong. Kindly contact the support team. ("+response.message+")",
                                  "type": "success",
                                  "confirmButtonClass": "btn btn-success"
                              });
                          }
                          setTimeout(function() {
                              window.location.reload(true);
                          },timeout);
                      },
                      error: function(error) {
                          console.log(error)
                      },
                  });
                  
              } else {
                  //transaction failed
                  swal.fire({
                      "title": "Success",
                      "text": response.message,
                      "type": "success",
                      "confirmButtonClass": "btn btn-success"
                  });
                  $("#paystack_response").html(response.message);
                  // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', false);
              }
          });
      },
      onClose: function () {
          //when the user close the payment modal
          // btn.addClass('kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light').attr('disabled', false);
          // $("#paystack_response").html("Payment cancelled");
          swal.fire({
              "title": "Success",
              "text": "Your payment was cancelled",
              "type": "success",
              "confirmButtonClass": "btn btn-success"
          });
      }
  });
  handler.openIframe(); //open the paystack's payment modal

});

var showPaymentDialog = function(order_no, amount_1, amount_2) {
  $("#order_no").val(order_no);
  $("#amount_to_pay").val(amount_1);
  document.getElementById("pay_with_paystack_submit").click();

  return false;
}