'use strict';

$(document).ready(function() {

    let delivery_date = document.querySelector('.delivery_date');
    if (delivery_date) {
        delivery_date.flatpickr({
            dateFormat: "Y-m-d"
        })
    }

    let delivery_date_range = $('.job_card_date_range')
    if(delivery_date_range) {
        delivery_date_range.flatpickr({
            mode: "range"
        })
    }

    $(function() {
        $('.job_type_id').select2({
            theme: "bootstrap-5",
            templateResult: function (data) {
                if (data.id === 'create-job-type') {
                    return $('<span class="select2-option-with-icon">' +
                        '<i class="bx bxs-briefcase me-2 text-success"></i>' +
                        '<span class="option-text text-success">' + data.text + '</span>' +
                        '</span>');
                }
                return data.text;
            },
            templateSelection: function (data) {
                if (data.id === 'create-job-type') {
                    return $('<span class="select2-option-with-icon-selected">' +
                        '<i class="bx bxs-briefcase me-2 text-success"></i>' +
                        '<span class="option-text">' + data.text + '</span>' +
                        '</span>');
                }
                return data.text;
            }
        });

        $('.customer_id').select2({
            theme: "bootstrap-5",
            templateResult: function (data) {
                if (data.id === 'create-customer') {
                    return $('<span class="select2-option-with-icon">' +
                        '<i class="bx bx-user-plus me-2 text-success" ></i>' +
                        '<span class="option-text text-success">' + data.text + '</span>' +
                        '</span>');
                }
                return data.text;
            },
            templateSelection: function (data) {
                if (data.id === 'create-customer') {
                    return $('<span class="select2-option-with-icon-selected">' +
                        '<i class="bx bx-user-plus me-2 text-success" ></i>' +
                        '<span class="option-text">' + data.text + '</span>' +
                        '</span>');
                }
                return data.text;
            }
        });
    })


    //datatable
    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/job/job-cards-list?status='+'all'+'',
        columns: [{
                data: 'plus-icon',
                name: 'plus-icon'
            },
            {
                data: 'job_card_no',
                name: 'job_card_no'
            },
            {
                data: 'job_title',
                name: 'job_title'
            },
            {
                data: 'job_type_id',
                name: 'job_type_id'
            },
            {
                data: 'customer_id',
                name: 'customer_id'
            },
            {
                data: 'contact_person',
                name: 'contact_person'
            },
            {
                data: 'delivery_date',
                name: 'delivery_date'
            },
            {
                data: 'action',
                data: 'action',
            }
        ],
        columnDefs: [{
            targets: 'no-sort',
            sortable: false,
            searchable: false
        }, {
            targets: [0],
            class: 'control'
        }],
        initComplete: function(settings, json) {
            $('.total-records').text(json.recordsTotal);
        }
    })

    //filter
    $(document).on('click', '.job_card_filter_btn', function() {
        let status = $(this).data('job_card_status');
        table.ajax.url('/admin/job/job-cards-list?status=' + status).load(function(response) {
            $('.total-records').text(response.recordsTotal);
        });

        $('.job_card_date_range').val('');

        // click button color change
        $('.job_card_filter_btn').removeClass('btn-warning').addClass('btn-outline-warning');
        $(this).removeClass('btn-outline-warning').addClass('btn-warning');
    });

    //date range filter
    $(document).on('change', '.job_card_date_range', function() {
        let date_range = $(this).val();
        let status = $('.btn-warning.job_card_filter_btn').data('job_card_status')

        table.ajax.url('/admin/job/job-cards-list?date_range='+date_range+'&status='+status).load();
    })

    // job type form pop up when click create
    $(document).on('change', '.job_type_id', function(e) {
        let value = $(this).val();

        if(value == 'create-job-type') {
            $('#jobTypeModal').modal('show');
        }
    })

    //save job type
    $(document).on('click', '.create-job-type', function() {
        let job_type_name = $('.job_type_name').val();

        if(job_type_name == null || job_type_name == '') {
            warning_alert('Please fill job type !')
            return;
        }

        if(job_type_name != null) {
            $.ajax({
                url: '/admin/job/job-cards/create-job-type',
                data: {
                    job_type_name,
                },
                success: function(res) {
                    $('#jobTypeModal').modal('hide');
                    $('.job_type_name').val('');

                    if(res) {
                        $('.job_type_id').val('').trigger('change.select2')
                        let option = `<option value="${res.id}">${res.name}</option>`;

                        $('.job_type_id').prepend(option);
                    }
                }
            })
        }
    })

    // customer form pop up when click create
    $(document).on('change', '.customer_id', function() {
        let value = $(this).val();

        if(value == 'create-customer') {
            $('#CustomerModal').modal('show');
        }
    })

    //save customer
    $(document).on('click', '.create-customer', function() {
        let customer_name = $('.customer_name').val();
        let customer_phone = $('.customer_phone').val();
        let customer_email = $('.customer_email').val();
        let address = $('.address').val();

        if(customer_name == null || customer_name == '') {
            warning_alert('Please fill custoemr name !');
            return;
        }

        if(customer_name != null) {
            $.ajax({
                url: '/admin/job/job-cards/create-customer',
                data: {
                    customer_name, customer_phone, customer_email, address
                },
                success: function(res) {
                    $('#CustomerModal').modal('hide');
                    $('.customer_name').val('');
                    $('.customer_phone').val('');
                    $('.customer_email').val('');
                    $('.address').val('');

                    if(res) {
                        $('.customer_id').val('').trigger('change.select2');
                        let option = `<option value="${res.id}">${res.customer_name}</option>`;
                        $('.customer_id').prepend(option);
                    }
                }
            })
        }
    })

    //submit create form
    $(document).on("submit", "#job_card_create", function (e) {
        e.preventDefault();

        let names = [
            "job_title",
            "job_type_id",
            "customer_id",
            "contact_person",
            "contact_phone",
            "delivery_date",
        ];

        let err = [];

        names.forEach((name) => {
            if ($(`.${name}`).val() == "" || $(`.${name}`).val() == null) {
                $(`.${name}_err`).html("Need to be filled");
                err.push(name);
            } else {
                $(`.${name}_err`).html(" ");
                if (err.includes(name)) {
                    err.splice(err.indexOf(`${name}`), 1);
                }
            }
        });

        if (err.length > 0) {
            toast_error("Please fill require fields !");
            window.scrollTo(0, 0);
            return;
        }

        if (err.length == 0) {
            ask_confirm().then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData(
                        $("#job_card_create")[0]
                    );

                    $.ajax({
                        url: "/admin/job/job-cards",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (res) {
                            if (res == "success") {
                                window.location.href = "/admin/job/job-cards";
                            }
                        },
                        error: function (xhr, status, err) {
                            //validation error
                            if (xhr.status === 422) {
                                let noti = ``;
                                for (const key in xhr.responseJSON.errors) {
                                    noti += `
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        ${xhr.responseJSON.errors[key][0]}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                `;
                                }

                                $(".error").html(noti);

                                toast_error("Something went wrong !");

                                // Scroll to the top of the browser window
                                $("html, body").animate({ scrollTop: 0 });
                            } else {
                                toast_error("Something wrong");
                            }
                        },
                    });
                }
            });
        }
    });

    //submit edit form
    $(document).on("submit", "#job_card_edit", function (e) {
        e.preventDefault();

        let names = [
            "job_title",
            "job_type_id",
            "customer_id",
            "contact_person",
            "contact_phone",
            "delivery_date",
        ];

        let err = [];

        names.forEach((name) => {
            if ($(`.${name}`).val() == "" || $(`.${name}`).val() == null) {
                $(`.${name}_err`).html("Need to be filled");
                err.push(name);
            } else {
                $(`.${name}_err`).html(" ");
                if (err.includes(name)) {
                    err.splice(err.indexOf(`${name}`), 1);
                }
            }
        });

        if (err.length > 0) {
            toast_error("Please fill require fields !");
            window.scrollTo(0, 0);
            return;
        }

        if (err.length == 0) {
            ask_confirm().then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData(
                        $("#job_card_edit")[0]
                    );

                    let id = $('.job_card_id').val();

                    $.ajax({
                        url: "/admin/job/job-cards/update/"+id,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (res) {
                            if (res == "success") {
                                window.location.href = "/admin/job/job-cards";
                            }
                        },
                        error: function (xhr, status, err) {
                            //validation error
                            if (xhr.status === 422) {
                                let noti = ``;
                                for (const key in xhr.responseJSON.errors) {
                                    noti += `
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        ${xhr.responseJSON.errors[key][0]}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                `;
                                }

                                $(".error").html(noti);

                                toast_error("Something went wrong !");

                                // Scroll to the top of the browser window
                                $("html, body").animate({ scrollTop: 0 });
                            } else {
                                toast_error("Something wrong");
                            }
                        },
                    });
                }
            });
        }
    });

    //delete function
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure to delete ?',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/roles/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        table.ajax.reload();
                    }
                })
            }
        })
    })
})
