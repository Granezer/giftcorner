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
                    url: endPoint + 'get-activities.php',
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
                message: 'Please wait! Loading activities...',
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
            field: "profile_image_url",
            title: "Image",
            autoHide: false,
            // callback function support for column rendering
            template: function(data) {
                // <img src="assets/media/uploaded-documents/' + data.document_url + '" alt="photo">\
                var image = data.profile_image_url;
                var output = '\
                    <div class="kt-user-card-v2 kt-user-card-v2--uncircle">\
                        <div class="kt-user-card-v2__pic">\
                            <a href=""><img style="height:35px;" src="' + image + '" alt="photo"></a>\
                        </div>\
                    </div>';

                return output;
            }
        }, {
            field: 'fullname',
            title: 'Name',
            autoHide: false,
        }, {
            field: 'report_type',
            title: 'Report Type',
        }, {
            field: 'description',
            title: 'Description',
        }, {
            field: 'date_time',
            title: 'Date',
            autoHide: false,
        },],
    };

    // basic demo
    var loadProducts = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_activities').KTDatatable(options);

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