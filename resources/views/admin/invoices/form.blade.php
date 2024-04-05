<form action="{{ route('admin.invoices.store') }}" method="post" id="{{request()->is('admin/job/invoices/create') ? 'invoice_create' : 'invoice_edit'}}">
    @csrf
    <div class="row">
        <div class="col-2 mb-4">
            <div class="form-group">
                <label for="">Job Card <span class="text-danger">***</span></label>
                <select name="job_card_id" class="select2 form-select job_card_id" data-placeholder="--- Please Select ---" required>
                    <option value=""></option>
                    @foreach ($jobCards as $jobCard)
                        <option value="{{$jobCard->id}}" {{isset($invoice) && $invoice->job_card_id == $jobCard->id ? 'selected' : ''}}>{{$jobCard->job_card_no}}</option>
                    @endforeach
                </select>
                <span class="text-danger job_card_id_err"></span>
            </div>
        </div>

        <div class="col-10 col-sm-8 mb-4">
            <div class="form-group">
                <label for="">Customer Name</label>
                <input type="text" readonly class="form-control customer_name" value="{{isset($invoice) ? $invoice->customer->customer_name : ''}}">
            </div>
        </div>

        <div class="col-5 col-sm-2 mb-4">
            <div class="form-group">
                <label for="">Date</label>
                <input type="date" name="date" class="form-control date bg-transparent" value="{{$current_date}}">
            </div>
        </div>

        <div class="col-12 col-sm-10 mb-4">
            <div class="form-group">
                <label for="">Address </label>
                <input type="text"class="form-control address" readonly value="{{isset($invoice) ? $invoice->customer->address : ''}}">
            </div>
        </div>

        <div class="col-5 col-sm-2 mb-4">
            <div class="form-group">
                <label for="">Vou No</label>
                <input type="text" name="voucher_no" class="form-control bg-transparent" required value="{{isset($invoice) ? $invoice->voucher_no : ''}}">
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="d-flex justify-content-end mb-3">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-danger del-invoice-btn">Delete</button>
                <button type="button" class="btn btn-success add-invoice-btn">Add Row</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr style="background:#F3F3F3; border-radius: 10px;">
                        <th class="text-center"><input class="invoice-check-all" name="invoice-check-all" type="checkbox"></th>
                        <th>No</th>
                        <th>Particular</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody class="invoiceGroup">
                    @if(!isset($invoice))
                        <tr class="invoice-row">
                            <td class="text-center"><input class="invoice-checkbox" name="invoice-checkbox" type="checkbox"></td>
                            <td class="invoice-no">1</td>
                            <td style="width: 500px;"><input type="text" name="particular[]" class="table-input w-100"></td>
                            <td style="width: 200px;"><input type="number" name="qty[]" value="0" class="w-100 table-input qty"></td>
                            <td style="width: 200px;"><input type="number" name="rate[]" value="0" class="w-100 table-input rate"></td>
                            <td style="width: 200px;"><input type="text" name="amount[]" value="0" class="w-100 table-input amount" readonly ></td>
                        </tr>
                    @else
                        @foreach ($invoice->particulars as $particular)
                            <tr class="invoice-row">
                                <td class="text-center"><input class="invoice-checkbox" name="invoice-checkbox" type="checkbox"></td>
                                <td class="invoice-no">{{$loop->iteration}}</td>
                                <td style="width: 500px;"><input type="text" name="particular[]" value="{{$particular->particular_name}}" class="table-input w-100"></td>
                                <td style="width: 200px;"><input type="number" name="qty[]" value="{{$particular->qty}}" class="w-100 table-input qty"></td>
                                <td style="width: 200px;"><input type="number" name="rate[]" value="{{$particular->rate}}" class="w-100 table-input rate"></td>
                                <td style="width: 200px;"><input type="text" name="amount[]" value="{{$particular->amount}}" class="w-100 table-input amount" readonly ></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="foot mt-3">
            <div class="row mb-1">
                <div class="col-1 offset-9 pt-1">Total</div>
                <div class="col-2"><input type="text" name="total" class="form-control w-100 total" value="{{isset($invoice) ? $invoice->total : 0}}" readonly></div>
            </div>
            <div class="row mb-1">
                <div class="col-1 offset-9 pt-1">Advance</div>
                <div class="col-2"><input type="number" name="advance" class="form-control w-100 advance" value="{{isset($invoice) ? $invoice->advance : 0}}"></div>
            </div>
            <div class="row mb-1">
                <div class="col-1 offset-9 pt-1">Balance</div>
                <div class="col-2"><input type="text" name="balance" class="form-control w-100 balance" value="{{isset($invoice) ? $invoice->balance : 0}}" readonly></div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <hr>
        <button class="btn btn-secondary back-btn">Cancel</button>
        @if (!isset($invoice))
        <button class="btn btn-primary">Save</button>
        @endif
    </div>
</form>
