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
                        status: product_status
                    },
                    url: endPoint + 'get-products.php',
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
            autoHide: false,
        }, {
            field: "image_urls",
            title: "Image",
            autoHide: false,
            // callback function support for column rendering
            template: function(data) {
                // <img src="assets/media/uploaded-documents/' + data.document_url + '" alt="photo">\
                var image = data.image_urls,
                    l = "";
                if (image) {
                    if (image.includes('|')) {
                        var images = image.split('|');
                        image = images[0];

                        l = images.length;
                        if (l > 1) {
                            l = l - 1;
                            l = l + "+";
                        }

                    } else image = data.image_urls;
                } 

                var filetype = '',
                    image_exts = ["jpg", "jpeg", "png", "gif"],
                    file_ext = get_file_ext(image);

                if (image_exts.includes(file_ext)) {
                    filetype = '<img style="height:50px;" src="' + productImages + image + '" alt="'+image+'">';
                } else {
                    filetype = '<video style="height: 30px;" controls autoplay muted>\
                                    <source src="' + productImages + image + '" type="video/'+ file_ext +'">\
                                </video>';
                }
                
                var output = '\
                    <div class="kt-user-card-v2 kt-user-card-v2--uncircle">\
                        <div class="kt-user-card-v2__pic">\
                            <a href="' + productImages + image + '" target="_blank">'+ filetype +'</a>\
                            <span>'+ l +'</span>\
                        </div>\
                    </div>';

                return output;
            }
        }, {
            field: 'name',
            title: 'Product Name',
            autoHide: false,
        }, {
            field: 'price',
            title: 'Price',
        }, {
            field: 'product_off',
            title: 'Product Off',
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
                };
                return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
            },
        }, {
            field: 'short_desc',
            title: 'Short Description',
        }, {
            field: 'date_time',
            title: 'Date Uploaded',
        }, {
            field: '',
            title: 'Actions',
            sortable: false,
            overflow: 'visible',
            textAlign: 'left',
            autoHide: false,
            template: function(data) {
                    return '\
                            <div class="dropdown">\
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                    <i class="flaticon-more-1"></i>\
                                </a>\
                                <div class="dropdown-menu dropdown-menu-right">\
                                    <ul class="kt-nav">\
                                        <li class="kt-nav__item">\
                                            <a href="products/edit-product?id=' + data.id + '" class="kt-nav__link">\
                                                <i class="kt-nav__link-icon flaticon2-expand"></i>\
                                                <span class="kt-nav__link-text">Edit</span>\
                                            </a>\
                                        </li>\
                                        <li class="kt-nav__item">\
                                            <a href="products/new-product?template=' + data.id + '" class="kt-nav__link">\
                                                <i class="kt-nav__link-icon la la-industry"></i>\
                                                <span class="kt-nav__link-text">Duplicate</span>\
                                            </a>\
                                        </li>\
                                    </ul>\
                                </div>\
                            </div>\
                        ';
                }
        }],
    };

    // basic demo
    var loadProducts = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_products').KTDatatable(options);

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

        $('#kt_modal_fetch_product_id_to_delete').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var product_ids = [];
            $("#delete-msg").html("Are you sure you want to delete the below listed product id(s)?");
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Product ID: ' + ids[i];
                c.appendChild(li);
                product_ids[i] = ids[i];
            }
            $("#product_ids").val(product_ids);
            $(e.target).find('.kt-datatable_selected_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_ids').empty();
        });

        $('#kt_modal_fetch_product_id_to_update').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var product_ids = [];
            $(".transaction_id").val(getTransactionId());
            $(".employee_id").val(getCookie("employee_id"));
            $(".user_ses_id").val(getCookie("user_ses_id"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Product ID: ' + ids[i];
                c.appendChild(li);
                product_ids[i] = ids[i];
            }
            $("#ids").val(product_ids);
            $(e.target).find('.kt-datatable_selected_product_ids').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_product_ids').empty();
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