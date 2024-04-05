@extends('layouts.app')
@section('title', 'Edit Job Card')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-notepad' style="color: rgb(235, 116, 18);"></i>
        <div>Job Card Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Job Card Edition</span>

        @include('admin.job_card.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/job_card.js')}}"></script>
@endsection
