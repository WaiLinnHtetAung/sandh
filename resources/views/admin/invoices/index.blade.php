@extends('layouts.app')
@section('title', 'Invoice')

@section('styles')
@endsection

@section('content')
    <div class="card-head-icon d-flex justify-content-between mt-5">
        <div class="d-flex">
            <i class='bx bxs-notepad' style="color: rgb(235, 116, 18);"></i>
            <div>Invoice</div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Invoice Lists</span>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                class='bx bxs-plus-circle me-2'></i>
            Create New Invoice</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Invoice No</th>
                    <th>Voucher No</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Balance</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('js/invoice.js')}}"></script>
@endsection
