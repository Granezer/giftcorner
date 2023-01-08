"use strict";
// Class definition

var KTUserListDatatable = function() {

	// variables
	var datatable;

	// init
	var init = function() {
		// init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
		datatable = $('#kt_apps_vendor_list_datatable').KTDatatable({
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
	                    },
						url: endPoint + 'get-vendors.php',
					},
				},
				pageSize: 10, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch'),
				delay: 400,
			},

			// columns definition
			columns: [{
				field: 'id',
				title: '#',
				sortable: false,
				width: 20,
				selector: {
					class: 'kt-checkbox--solid'
				},
				textAlign: 'center',
			}, {
				field: "company_name",
				title: "Company Name",
				width: 200,
				// callback function support for column rendering
				template: function(data, i) {
					var output = '<div class="kt-user-card-v2">\
						<div class="kt-user-card-v2__pic">\
							<img src="assets/media/vendors/' + data.logo_image_name + '" alt="photo">\
						</div>\
						<div class="kt-user-card-v2__details">\
							<a href="vendors/basic-info?id=' + data.id + '" class="kt-user-card-v2__name">' +  data.company_name + '</a>\
						</div>\
					</div>';

					return output;
				}
			}, {
				field: 'email',
				title: 'Email',
				// callback function support for column rendering
				template: function(row, i) {
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.email + '</a>';
					return output;
				}
			}, {
				field: 'phone1',
				title: 'Phone',
				// callback function support for column rendering
				template: function(row, i) {
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.phone1 + '</a>';
					return output;
				}
			}, {
				field: 'address1',
				title: 'Contact Address',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.address1) row.address1 = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.address1 + '</a>';
					return output;
				}
			}, {
				field: 'post_code',
				title: 'Postal Code',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.post_code) row.post_code = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.post_code + '</a>';
					return output;
				}
			}, {
				field: 'city',
				title: 'City',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.city) row.city = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.city + '</a>';
					return output;
				}
			}, {
				field: 'lga',
				title: 'L.G.A',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.lga) row.lga = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.lga + '</a>';
					return output;
				}
			}, {
				field: 'state',
				title: 'State',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.state) row.state = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.state + '</a>';
					return output;
				}
			}, {
				field: 'country',
				title: 'Country',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.country) row.country = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.country + '</a>';
					return output;
				}
			}, {
				field: 'bank_name',
				title: 'Bank Name',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.bank_name) row.bank_name = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.bank_name + '</a>';
					return output;
				}
			}, {
				field: 'acc_name',
				title: 'Account Name',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.acc_name) row.acc_name = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.acc_name + '</a>';
					return output;
				}
			}, {
				field: 'acc_no',
				title: 'Account No.',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.acc_no) row.acc_no = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.acc_no + '</a>';
					return output;
				}
			}, {
				field: 'bank_sort_code',
				title: 'Bank Sort Code.',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.bank_sort_code) row.bank_sort_code = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.bank_sort_code + '</a>';
					return output;
				}
			}, {
				field: 'contact_name',
				title: 'Contact Name',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.contact_name) row.contact_name = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.contact_name + '</a>';
					return output;
				}
			}, {
				field: 'contact_phone',
				title: 'Contact phone',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.contact_phone) row.contact_phone = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.contact_phone + '</a>';
					return output;
				}
			}, {
				field: 'contact_address',
				title: 'Contact Address',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.contact_address) row.contact_address = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.contact_address + '</a>';
					return output;
				}
			}, {
				field: 'contact_email',
				title: 'Contact Email',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.contact_email) row.contact_email = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.contact_email + '</a>';
					return output;
				}
			}, {
				field: 'contact_position',
				title: 'Contact Position',
				// callback function support for column rendering
				template: function(row, i) {
					if (!row.contact_position) row.contact_position = "N/A";
					var output = '\
						<a href="vendors/basic-info?id=' + row.id + '" class="kt-user-card-v2__name" style="color:#666;">' + row.contact_position + '</a>';
					return output;
				}
			}, {
				field: "Actions",
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
											<a href="vendors/basic-info?id=' + row.id + '" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-expand"></i>\
												<span class="kt-nav__link-text">View</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="vendors/basic-info?id=' + row.id + '" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Edit</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="employees/reset-employee-password?id=' + row.uuid + '" class="kt-nav__link">\
												<i class="kt-nav__link-icon fa fa-key"></i>\
												<span class="kt-nav__link-text">Reset Password</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="#" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-trash"></i>\
												<span class="kt-nav__link-text">Delete</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						';
				},
			}]
		});
	}

	// search
	var search = function() {
		// $('#kt_form_status').on('change', function() {
		// 	datatable.search($(this).val().toLowerCase(), 'Status');
		// });
	}

	// selection
	var selection = function() {
		// init form controls
		//$('#kt_form_status, #kt_form_type').selectpicker();

		// event handler on check and uncheck on records
		datatable.on('kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',	function(e) {
			var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes(); // get selected records
			var count = checkedNodes.length; // selected records count

			$('#kt_subheader_group_selected_rows').html(count);
				
			if (count > 0) {
				$('#kt_subheader_search').addClass('kt-hidden');
				$('#kt_subheader_group_actions').removeClass('kt-hidden');
			} else {
				$('#kt_subheader_search').removeClass('kt-hidden');
				$('#kt_subheader_group_actions').addClass('kt-hidden');
			}
		});
	}

	// fetch selected records
	var selectedFetch = function() {
		// event handler on selected records fetch modal launch
		$('#kt_datatable_records_fetch_modal').on('show.bs.modal', function(e) {
			// show loading dialog
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function() {
                loading.hide();
			}, 1000);
			
			// fetch selected IDs
			var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
				return $(chk).val();
			});

			// populate selected IDs
			var c = document.createDocumentFragment();
				
			for (var i = 0; i < ids.length; i++) {
				var li = document.createElement('li');
				li.setAttribute('data-id', ids[i]);
				li.innerHTML = 'Selected record ID: ' + ids[i];
				c.appendChild(li);
			}

			$(e.target).find('#kt_apps_user_fetch_records_selected').append(c);
		}).on('hide.bs.modal', function(e) {
			$(e.target).find('#kt_apps_user_fetch_records_selected').empty();
		});
	};

	// selected records status update
	var selectedStatusUpdate = function() {
		$('#kt_subheader_group_actions_status_change').on('click', "[data-toggle='status-change']", function() {
			var status = $(this).find(".kt-nav__link-text").html();

			// fetch selected IDs
			var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
				return $(chk).val();
			});

			if (ids.length > 0) {
				// learn more: https://sweetalert2.github.io/
				swal.fire({
					buttonsStyling: false,

					html: "Are you sure to update " + ids.length + " selected records status to " + status + " ?",
					type: "info",
	
					confirmButtonText: "Yes, update!",
					confirmButtonClass: "btn btn-sm btn-bold btn-brand",
	
					showCancelButton: true,
					cancelButtonText: "No, cancel",
					cancelButtonClass: "btn btn-sm btn-bold btn-default"
				}).then(function(result) {
					if (result.value) {
						swal.fire({
							title: 'Deleted!',
							text: 'Your selected records statuses have been updated!',
							type: 'success',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						})
						// result.dismiss can be 'cancel', 'overlay',
						// 'close', and 'timer'
					} else if (result.dismiss === 'cancel') {
						swal.fire({
							title: 'Cancelled',
							text: 'You selected records statuses have not been updated!',
							type: 'error',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						});
					}
				});
			}
		});
	}

	// selected records delete
	var selectedDelete = function() {
		$('#kt_subheader_group_actions_delete_all').on('click', function() {
			// fetch selected IDs
			var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
				return $(chk).val();
			});

			if (ids.length > 0) {
				// learn more: https://sweetalert2.github.io/
				swal.fire({
					buttonsStyling: false,

					text: "Are you sure to delete " + ids.length + " selected records ?",
					type: "danger",

					confirmButtonText: "Yes, delete!",
					confirmButtonClass: "btn btn-sm btn-bold btn-danger",

					showCancelButton: true,
					cancelButtonText: "No, cancel",
					cancelButtonClass: "btn btn-sm btn-bold btn-brand"
				}).then(function(result) {
					if (result.value) {
						swal.fire({
							title: 'Deleted!',
							text: 'Your selected records have been deleted! :(',
							type: 'success',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						})
						// result.dismiss can be 'cancel', 'overlay',
						// 'close', and 'timer'
					} else if (result.dismiss === 'cancel') {
						swal.fire({
							title: 'Cancelled',
							text: 'You selected records have not been deleted! :)',
							type: 'error',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						});
					}
				});
			}
		});		
	}

	var updateTotal = function() {
		datatable.on('kt-datatable--on-layout-updated', function () {
			//$('#kt_subheader_total').html(datatable.getTotalRows() + ' Total');
		});
	};

	return {
		// public functions
		init: function() {
			init();
			search();
			selection();
			selectedFetch();
			selectedStatusUpdate();
			selectedDelete();
			updateTotal();
		},
	};
}();

// On document ready
KTUtil.ready(function() {
	KTUserListDatatable.init();
});