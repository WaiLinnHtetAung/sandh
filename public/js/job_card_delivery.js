'use strict';

$(document).ready(function() {

    // date picker
    let delivery_date_range = $('.delivery_date_range')
    if(delivery_date_range) {
        delivery_date_range.flatpickr({
            mode: "range"
        })
    }

    //datatable
    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/job/delivery-list?status='+'today'+'',
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
                data: 'complete',
                data: 'complete',
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

    // filter function
    $(document).on('click', '.delivery_date_filter_btn', function(e) {
        let status = $(this).data('delivery_date');

        table.ajax.url('/admin/job/delivery-list?status=' + status).load();

        if(status == 'all') {
            $('.delivery_date_range').removeClass('d-none').val('');
        } else {
            $('.delivery_date_range').addClass('d-none')
        }

        // click button color change
        $('.delivery_date_filter_btn').removeClass('btn-warning').addClass('btn-outline-warning');
        $(this).removeClass('btn-outline-warning').addClass('btn-warning');
    })

    //date range filter
    $(document).on('change', '.delivery_date_range', function() {
        let date_range = $(this).val();

        let status = $('.btn-warning.delivery_date_filter_btn').data('delivery_date');

        table.ajax.url('/admin/job/delivery-list?date_range='+date_range+'&status='+status).load();
    })

    //complete job card
    $(document).on('click', '.complete-job-card', function() {
        let id = $(this).data('id');

        if(id) {
            ask_confirm().then(result => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/admin/job/delivery/complete',
                        data: {id},
                        success: function(res) {
                            if(res =='success') {
                                toast_success('Successfully Changed');
                                table.ajax.reload();
                            }
                        }
                    })
                }
            })
        }
    })
})
