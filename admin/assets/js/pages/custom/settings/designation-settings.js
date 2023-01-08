"use strict";
// Class definition

var KTDatatableDesignations = function() {
    // Private functions

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    method: 'GET',
                    headers: { 'Authorization': api_key },
                    params: {
                        // getTransactionId() method has been defined in assets/js/pages/custom/general/generals.js
                        transaction_id: getTransactionId(),
                        employee_id: getCookie("employee_id"),
                        user_ses_id: getCookie("user_ses_id")
                    },
                    url: endPoint + 'settings/get-designations',
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
                message: 'Please wait! Loading designation settings...',
            },
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition
        columns: [
            {
                field: 'id',
                title: '#',
                sortable: false,
                width: 20,
                selector: {
                    class: 'kt-checkbox--solid'
                },
                textAlign: 'center',
                autoHide: false,
            }, {
				field: 'name',
				title: 'Name',
                // callback function support for column rendering
                template: function(row) {
                    var output = '\
                        <a href="settings/edit-designation-setting?id=' + row.id + '" style="color:#666;">'+ row.name +'</a>';

                    return output;
                }
			}, {
                field: 'date_time',
                title: 'Date Added',
                // callback function support for column rendering
                template: function(row) {
                    var output = '\
                        <a href="settings/edit-designation-setting?id=' + row.id + '" style="color:#666;">'+ formatDate(row.date_time) +'</a>';

                    return output;
                }
            }, {
				field: "",
				width: 80,
				title: "Actions",
				sortable: false,
				autoHide: false,
				overflow: 'visible',
				template: function(row) {
					return '\
						<div class="dropdown">\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
								<i class="flaticon-more-1"></i>\
							</a>\
							<div class="dropdown-menu dropdown-menu-right">\
								<ul class="kt-nav">\
									<li class="kt-nav__item">\
										<a href="settings/edit-designation-setting?id=' + row.id + '" class="kt-nav__link">\
											<i class="kt-nav__link-icon flaticon2-contract"></i>\
											<span class="kt-nav__link-text">Edit</span>\
										</a>\
									</li>\
								</ul>\
							</div>\
						</div>\
					';
				},
			}
        ],
    };

    // basic demo
    var loadDesignationSettings = function() {

        options.search = {
            input: $('#generalSearch'),
        };

        var datatable = $('#load_designation_settings').KTDatatable(options);

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

        $('#kt_modal_fetch_activate_designation_setting').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.kt-datatable__row--active').
            nodes().
            find('.kt-checkbox--single > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            var designation_setting_ids = [];
            $(".transaction_id").val(getTransactionId());
            $(".admin_username").val(getCookie("admin_username"));

            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected Designation Setting ID: ' + ids[i];
                c.appendChild(li);
                designation_setting_ids[i] = ids[i];
                break;
            }
            $("#ids").val(designation_setting_ids);
            $(e.target).find('.kt-datatable_selected_designation_setting_id').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('.kt-datatable_selected_designation_setting_id').empty();
        });

    };

    return {
        // public functions
        init: function() {
            loadDesignationSettings();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableDesignations.init();
});