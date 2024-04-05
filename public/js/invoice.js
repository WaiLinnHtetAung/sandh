'use strict';

$(document).ready(function() {
    //global variable
    let customer_id;

    let date = document.querySelector('.date');
    if (date) {
        date.flatpickr({
            dateFormat: "Y-m-d"
        })
    }

    //datatable
    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/job/invoices-list',
        columns: [{
                data: 'plus-icon',
                name: 'plus-icon'
            },
            {
                data: 'invoice_no',
                name: 'invoice_no'
            },
            {
                data: 'voucher_no',
                name: 'voucher_no'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'customer_id',
                name: 'customer_id'
            },
            {
                data: 'balance',
                name: 'balance'
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

    //select job card
    $(document).on('change', '.job_card_id', function() {
        let id = $(this).val();

        if(id) {
            $.ajax({
                url: "/admin/job/invoices/get-customer-info",
                data: {id},
                success: function(res) {
                    customer_id = res.customer.id;
                    $('.customer_name').val(res.customer.customer_name)
                    $('.address').val(res.customer.address)
                }
            })
        }
    })

    // add new invoice row
    $(document).on('click', '.add-invoice-btn', function() {
        let lastInvoiceRow = $('.invoice-row').eq($('.invoice-row').length - 1);
        let invoiceNo = lastInvoiceRow.find('.invoice-no').text();

        let row = `
        <tr class="invoice-row">
            <td class="text-center"><input class="invoice-checkbox" name="invoice-checkbox" type="checkbox"></td>
            <td class="invoice-no">${++invoiceNo}</td>
            <td style="width: 500px;"><input type="text" name="particular[]" class="table-input w-100"></td>
            <td style="width: 200px;"><input type="number" name="qty[]" value="0" class="w-100 table-input qty"></td>
            <td style="width: 200px;"><input type="number" name="rate[]" value="0" class="w-100 table-input rate"></td>
            <td style="width: 200px;"><input type="text" name="amount[]" value="0" class="w-100 table-input amount" readonly ></td>
        </tr>
        `;

        $('.invoiceGroup').append(row);
    })

    //check all
    $(document).on('change', '.invoice-check-all', function() {
        $('.invoice-checkbox').prop('checked', true);
    })


    //calculate overall amount and balance
    const calculateTotalAmount = () => {

        let total_price = 0;
        $('.amount').each(function() {
            total_price += parseFloat($(this).val());
        })

        $('.total').val(total_price);

    }

    // calculate balance amount
    const calculateBalance = () => {
        let total_amount = $('.total').val();
        let advance_amount = $('.advance').val();
        $('.balance').val(total_amount - advance_amount);
    }

    // qty change, calculate price
    $(document).on('input', '.qty', function(e) {
        let qty = $(this).val();
        let rate = $(this).closest('.invoice-row').find('.rate').val();

        if(qty < 0) {
            warning_alert('Quantity must be postivie');
            $(this).val(0)
        } else {
            $(this).closest('.invoice-row').find('.amount').val(parseInt(qty) * parseFloat(rate));

            calculateTotalAmount();
        }
    })

    // rate change, calculate price
    $(document).on('input', '.rate', function() {
        let rate = $(this).val();
        let qty = $(this).closest('.invoice-row').find('.qty').val();

        if(rate < 0) {
            warning_alert('Rate must be postivie');
            $(this).val(0)
        } else {
            $(this).closest('.invoice-row').find('.amount').val(parseInt(qty) * parseFloat(rate));

            calculateTotalAmount();
        }
    })

    // advance change
    $(document).on('input', 'input', function() {
        let advance = $(this).val();

        if(advance < 0) {
            warning_alert('Advance Amount must be positive');
            $(this).val(0)
        } else {
            calculateBalance();
        }
    })

    // delete invoice row
    $(document).on('click', '.del-invoice-btn', function() {
        $('.invoice-checkbox:checked').each(function() {
            $(this).closest('.invoice-row').remove();
            $('.invoice-check-all').prop('checked', false);

            //reorder no
            $('.invoice-row').each(function(index) {
                $(this).find('.invoice-no').text(++index)
            })

            calculateTotalAmount();
            calculateBalance();
        })

    })

    //submit
    $(document).on('submit', '#invoice_create', function(e) {
        e.preventDefault();

        ask_confirm().then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData(
                    $("#invoice_create")[0]
                );

                formData.append('customer_id', customer_id);

                $.ajax({
                    url: "/admin/job/invoices",
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
                        console.log(res);
                        if (res == "success") {
                            window.location.href = "/admin/job/invoices";
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
    })

})
