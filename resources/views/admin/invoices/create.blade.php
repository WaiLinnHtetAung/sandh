@extends('layouts.app')
@section('title', 'Create Invoice')

@section('styles')
    <style>
        .invoice .table-input {
            border: none;
            padding: 10px;
        }

        .invoice .table-input:focus {
            outline: none;
        }
    </style>
@endsection

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-notepad' style="color: rgb(235, 116, 18);"></i>
        <div>Invoice Creation</div>
    </div>
    <div class="card invoice mt-3 p-4">
        <span class="mb-4">Invoice Creation</span>
        <div class="d-flex justify-content-center mb-3">
            <img src="{{asset('assets/img/invoice.jpeg')}}" alt="">
        </div>
        <hr class="mb-5">
        @include('admin.invoices.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/invoice.js')}}"></script>
@endsection
