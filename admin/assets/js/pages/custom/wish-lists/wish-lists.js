"use strict";
// Class definition

var KTDatatableProducts = function() {
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
                        user_id: user_id
                    },
                    url: endPoint + 'get-wishlists.php',
                    // url: 'http://localhost/test-aws/katlogg-admin/engine/actions/get-products.php',
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
                message: 'Please wait! Loading products...',
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
        }, {
            field: "product_images_urls",
            title: "Image",
            autoHide: false,
            // callback function support for column rendering
            template: function(data) {
                // <img src="assets/media/uploaded-documents/' + data.document_url + '" alt="photo">\
                var images = data.product_images_urls;
                images = images.split('|');
                var output = '\
                    <div class="kt-user-card-v2 kt-user-card-v2--uncircle">\
                        <div class="kt-user-card-v2__pic">\
                            <a href=""><img style="height:35px;" src="' + images[0] + '" alt="photo"></a>\
                        </div>\
                    </div>';

                return output;
            }
        }, {
            field: 'product_name',
            title: 'Product Name',
            autoHide: false,
        }, {
            field: 'product_current_price',
            title: 'Price',
        }, {
            field: 'fullname',
            title: 'Fullname',
            template: function(row) {
                if (row.fullname) return row.fullname;

                return 'Unknown User';
            },
        }, {
            field: 'category',
            title: 'Category',
            template: function(row) {
                return row.category + ' >>> ' + row.category_name;
            },
        }, {
            field: 'product_status',
            title: 'Status',
            autoHide: false,
            // callback function support for column rendering
            template: function(row) {
                
                var status = {
                    3: {'title': 'Under review', 'class': 'kt-badge--brand'},
                    1: {'title': 'Live on site', 'class': ' kt-badge--success'},
                    0: {'title': 'Paused', 'class': ' kt-badge--danger'},
                    2: {'title': 'Rejected', 'class': ' kt-badge--warning'},
                };
                return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
            },
        }, {
            field: 'date_time',
            title: 'Date Uploaded',
            autoHide: false,
        }, 
        // {
        //     field: '',
        //     title: 'Actions',
        //     sortable: false,
        //     overflow: 'visible',
        //     textAlign: 'left',
	       //  autoHide: false,
        //     template: function() {
	       //      return '\
        //             <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">\
        //                 <i class="la la-edit"></i>\
        //             </a>\
        //             <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">\
        //                 <i class="la la-trash"></i>\
        //             </a>\
        //         ';
        //     },
        // }
        ],
    };

    // basic demo
    var loadProducts = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_wish_lists').KTDatatable(options);

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

        $('#kt_modal_fetch_id').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });
            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected record ID: ' + ids[i];
                c.appendChild(li);
            }
            $(e.target).find('.kt-datatable_selected_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_ids').empty();
        });

    };

    return {
        // public functions
        init: function() {
            loadProducts();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableProducts.init();
});