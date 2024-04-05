@extends('layouts.app')
@section('title', 'Job Card')

@section('styles')
    <style>
        .job_card_date_range {
            color: #fff !important;
            font-weight: bold !important;
            font-size: 19px;
        }
        .job_card_date_range::placeholder {
            color: #fff;
            font-weight: bolder;
        }

        .job_card_date_range:focus {
            border-color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="card-head-icon d-flex justify-content-between mt-5">
        <div class="d-flex">
            <i class='bx bxs-notepad' style="color: rgb(235, 116, 18);"></i>
            <div>Job Card</div>
        </div>
        <a href="{{ route('admin.job-cards.create') }}" class="btn btn-primary text-decoration-none text-white"><i
            class='bx bxs-plus-circle me-2'></i>
        Create New Job Card</a>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <div class="d-flex gap-2">
                <button class="btn btn-warning fw-bold job_card_filter_btn" data-job_card_status="all">All</button>
                <button class="btn btn-outline-warning fw-bold job_card_filter_btn" data-job_card_status="complete">Completed</button>
                <button class="btn btn-outline-warning fw-bold job_card_filter_btn" data-job_card_status="pending">Pending</button>
            </div>
            <div>Total - <span class="total-records fw-bold"></span></div>
            <div class="me-2 w-25">
                <input type="date" class="form-control job_card_date_range bg-success w-100" placeholder="YYYY-MM-DD to YYYY-MM-DD">
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
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/job_card.js')}}"></script>
@endsection
