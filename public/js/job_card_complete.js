'use strict';

$(document).ready(function() {
    //datatable
    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/job/complete-job-cards-list',
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
                data: 'status',
                data: 'status',
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
    })
})
