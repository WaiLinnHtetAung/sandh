@extends('layouts.app')
@section('title', 'Complete Job Card')

@section('styles')
    <style>
        .delivery_date_range {
            color: #fff !important;
            font-weight: bold !important;
            font-size: 19px;
        }
        .delivery_date_range::placeholder {
            color: #fff;
            font-weight: bolder;
        }

        .delivery_date_range:focus {
            border-color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-calendar-check' style="color: rgb(92, 230, 0);"></i>
        <div>Completed Job Card</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            {{-- <div class="d-flex gap-2">
                <button class="btn btn-warning fw-bold delivery_date_filter_btn" data-delivery_date="today">Today</button>
                <button class="btn btn-outline-warning fw-bold delivery_date_filter_btn" data-delivery_date="tomorrow">Tomorrow</button>
                <button class="btn btn-outline-warning fw-bold delivery_date_filter_btn" data-delivery_date="overmorrow">Overmorrow</button>
                <button class="btn btn-outline-warning fw-bold delivery_date_filter_btn" data-delivery_date="all">All</button>
            </div> --}}
            <div class="me-2 w-25">
                <input type="date" class="form-control delivery_date_range bg-success w-100 d-none" placeholder="YYYY-MM-DD to YYYY-MM-DD">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th class="no-sort">Job Card No</th>
                    <th>Job Title</th>
                    <th>Job Type</th>
                    <th>Customer</th>
                    <th>Contact Person</th>
                    <th>Delivery Date</th>
                    <th class="no-sort text-nowrap">Status</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/job_card_complete.js')}}"></script>
@endsection
