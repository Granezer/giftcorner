"use strict";

// Class Definition
var KTDeleteGiftCard = function() {

    var handleDeleteGiftCard = function() {
        $('#kt_datatable_delete_all_gift_cards').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');
            
            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
            
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            form.ajaxSubmit({
                type: "POST",
                url: endPoint + "delete-gift-card.php",
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if (response['success']) {
                        $('.kt-datatable').KTDatatable('reload');
                        swal.fire({
                            "title": "Gift Card Deleted",
                            "text": response['message'],
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        $('#kt_modal_fetch_gift_card_id_to_delete').modal('hide');
                    } else {
                        swal.fire({
                            "title": "Gift Card Delete Error",
                            "text": response['message'],
                            "type": "warning",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleDeleteGiftCard();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTDeleteGiftCard.init();
});