<form action="{{ route('admin.job-cards.store') }}" method="post" id="{{request()->is('admin/job/job-cards/create') ? 'job_card_create' : 'job_card_edit'}}">
    @csrf
    <div class="row">
        <input type="hidden" class="job_card_id" value="{{isset($jobCard) ? $jobCard->id : ''}}">
        <div class="col-md-12 col-sm-12 mb-4">
            <div class="form-group">
                <label for="">Job Title <span class="text-danger">***</span></label>
                <input type="text" name="job_title" class="form-control job_title" value="{{ isset($jobCard)? $jobCard->job_title : ''}}">
                <span class="text-danger job_title_err"></span>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
        <div class="form-group">
                <label for="">Job Type <span class="text-danger">***</span></label>
                <select name="job_type_id" class="select2 form-control job_type_id" data-placeholder="--- Please Select ---">
                    <option value=""></option>
                    @foreach ($jobTypes as $jobType)
                        <option value="{{$jobType->id}}" {{isset($jobCard) && $jobCard->job_type_id == $jobType->id ? 'selected' : ''}}>{{$jobType->name}}</option>
                    @endforeach
                    <option value="create-job-type"> Create Job Type</option>
                </select>
                <span class="text-danger job_type_id_err"></span>
            </div>
            {{-- job type create form pop up  --}}

            <div class="modal fade" id="jobTypeModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel4">Create Job Type</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-group">
                                    <label for="">Job Type Name</label>
                                    <input type="text" name="job_type_name" class="form-control job_type_name">
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <hr>
                                <div class="d-flex align-content-center flex-wrap gap-2 justify-content-end mb-3 me-3">

                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="button" class="btn btn-primary create-job-type">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- job type create form pop up  --}}
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="form-group">
                <label for="">Customer <span class="text-danger">***</span></label>
                <select name="customer_id" class="select2 form-select customer_id" data-placeholder="--- Please Select ---">
                    <option value=""></option>
                    @foreach ($customers as $customer)
                        <option value="{{$customer->id}}"  {{isset($jobCard) && $jobCard->customer_id == $customer->id ? 'selected' : ''}}>{{$customer->customer_name}}</option>
                    @endforeach
                    <option value="create-customer"> Create Customer</option>
                </select>
                <span class="text-danger customer_id_err"></span>
            </div>

             {{-- customer create form pop up  --}}

             <div class="modal fade" id="CustomerModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel4">Create Customer</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.job_card.customer_form')
                        </div>
                    </div>
                </div>
            </div>

            {{-- customer create form pop up  --}}
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="form-group">
                <label for="">Contact Person <span class="text-danger">***</span></label>
                <input type="text" name="contact_person" class="form-control contact_person" value="{{ isset($jobCard)? $jobCard->contact_person : ''}}">
                <span class="text-danger contact_person_err"></span>
            </div>
        </div>

        <div class="col-12 col-md-6 mb-4">
            <div class="form-group">
                <label for="">Contact Phone <span class="text-danger">***</span></label>
                <input type="text" name="contact_phone" class="form-control contact_phone" value="{{ isset($jobCard)? $jobCard->contact_phone : ''}}">
                <span class="text-danger contact_phone_err"></span>
            </div>
        </div>

        <div class="col-12 col-md-6 mb-4">
            <div class="form-group mb-4">
                <label for="">Delivery Date <span class="text-danger">***</span></label>
                <input type="date" name="delivery_date" class="form-control delivery_date bg-transparent" placeholder="YYYY-MM-DD" value="{{ isset($jobCard)? $jobCard->delivery_date : ''}}">
                <span class="text-danger delivery_date_err"></span>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="form-group mb-4">
                <label for="">Remark</label>
                <textarea name="remark" id="" cols="30" rows="5" class="form-control remark">{{isset($jobCard) ? $jobCard->remark : ''}}</textarea>
                <span class="text-danger remark_err"></span>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <hr>
        <button class="btn btn-secondary back-btn">Cancel</button>
        <button class="btn btn-primary">Save</button>
    </div>
</form>
