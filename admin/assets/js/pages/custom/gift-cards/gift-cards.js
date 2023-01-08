"use strict";
// Class definition

var KTDatatableGiftCards = function() {
    // Private functions

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    method: 'GET',
                    params: {
                        // getTransactionId() method has been defined in assets/js/pages/custom/general/generals.js
                        transaction_id: getTransactionId(),
                        employee_id: getCookie("employee_id"),
                        user_ses_id: getCookie("user_ses_id"),
                        status: gift_card_status,
                        vendor_id: vendor_id,
                    },
                    url: endPoint + 'get-gift-cards.php',
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
            saveState: {
                webstorage: false,
                cookie: false,
            },
        },

        // layout definition
        layout: {
            scroll: false, // enable/disable datatable scroll both horizontal and
            // vertical when needed.
            //height: 950, // datatable's body's fixed height
            footer: true, // display/hide footer

            spinner: {
                message: 'Please wait! Loading gift cards...',
            },
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition

        columns: [{
            field: 'id',
            title: '#',
            sortable: true,
            width: 20,
            selector: {
                class: 'kt-checkbox--solid'
            },
            textAlign: 'center',
            autoHide: false,
        }, {
            field: "image_urls",
            title: "Image",
            autoHide: false,
            // callback function support for column rendering
            template: function(data) {
                // <img src="assets/media/uploaded-documents/' + data.document_url + '" alt="photo">\
                var image = "../backend/assets/media/giftcards/" + data.image_urls;
                var output = '\
                    <div class="kt-user-card-v2 kt-user-card-v2--uncircle">\
                        <div class="kt-user-card-v2__pic">\
                            <a href="' + image + '" target="_blank"><img style="height:35px;" src="' + image + '" alt="photo"></a>\
                        </div>\
                    </div>';

                return output;
            }
        }, {
            field: 'category_name',
            title: 'Category',
            autoHide: false,
        }, {
            field: 'name',
            title: 'Name',
            autoHide: false,
        }, {
            field: 'price',
            title: 'Price',
        }, {
            field: 'qty',
            title: 'Qty',
        }, {
            field: 'card_number',
            title: 'Card Number',
        }, {
            field: 'status',
            title: 'Status',
            // callback function support for column rendering
            template: function(row) {
                
                var status = {
                    3: {'title': 'Under review', 'class': 'kt-badge--brand'},
                    1: {'title': 'Live on site', 'class': ' kt-badge--success'},
                    0: {'title': 'Paused', 'class': ' kt-badge--danger'},
                    2: {'title': 'Rejected', 'class': ' kt-badge--warning'},
                    4: {'title': 'Soldout', 'class': ' kt-badge--dark'},
                };
                return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
            },
        }, {
            field: 'date_time',
            title: 'Date Uploaded',
        }, {
            field: 'card_pin',
            title: 'Card Pin',
        }, {
            field: 'used_status',
            title: 'Usage Status',
            // callback function support for column rendering
            template: function(row) {
                
                var status = {
                    'Valid': {'title': 'Valid', 'class': ' kt-badge--success'},
                    'Invalid': {'title': 'Invalid', 'class': ' kt-badge--danger'},
                    'Used': {'title': 'Used', 'class': ' kt-badge--warning'},
                };
                return '<span class="kt-badge ' + status[row.used_status].class + ' kt-badge--inline kt-badge--pill">' + status[row.used_status].title + '</span>';
            },
        }, {
            field: '',
            title: 'Actions',
            sortable: false,
            overflow: 'visible',
            textAlign: 'left',
	        autoHide: false,
            template: function(row) {
	            return '\
                    <a href="gift-cards/edit-gift-card?id='+ row.id +'&vendor_id='+ row.vendor_id + '&status='+ vendor_id +'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">\
                        <i class="la la-pencil"></i>\
                    </a>\
                ';
            },
        }],
    };

    // basic demo
    var loadGiftCards = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_gift_cards').KTDatatable(options);

        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val(), 'status');
        });

        // $('#kt_form_status,#kt_form_type').selectpicker();

        datatable.on(
            'kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',
            function(e) {
                var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_number').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            });

        $('#kt_modal_fetch_gift_card_id_to_delete').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var gift_card_ids = [];
            $("#delete-msg").html("Are you sure you want to delete the below listed gift card id(s)?");
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Gift Card ID: ' + ids[i];
                c.appendChild(li);
                gift_card_ids[i] = ids[i];
            }
            $(".gift_card_ids").val(gift_card_ids);
            $(e.target).find('.kt-datatable_selected_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_ids').empty();
        });

        $('#kt_modal_fetch_gift_card_id_to_update').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var gift_card_ids = [];
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Gift Card ID: ' + ids[i];
                c.appendChild(li);
                gift_card_ids[i] = ids[i];
            }
            $(".gift_card_ids").val(gift_card_ids);
            $(e.target).find('.kt-datatable_selected_gift_card_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_gift_card_ids').empty();
        });

        $('#kt_modal_fetch_gift_card_id_to_used').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var gift_card_ids = [];
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Gift Card ID: ' + ids[i];
                c.appendChild(li);
                gift_card_ids[i] = ids[i];
            }
            $(".gift_card_ids").val(gift_card_ids);
            $(e.target).find('.kt-datatable_selected_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_ids').empty();
        });
    };

    return {
        // public functions
        init: function() {
            loadGiftCards();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableGiftCards.init();
});