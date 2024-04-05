<div class="table-responsive">
    <table class="table table-bordered table-striped w-100" id="DataTable">
        <thead>
            <th class="no-sort">Job Card No</th>
            <th>Job Title</th>
            <th>Job Type</th>
            <th>Customer</th>
            <th>Contact Person</th>
            <th>Delivery Date</th>
        </thead>
        <tbody>
            @foreach ($jobCards as $jc)
                <tr>
                    <td>{{$jc->job_card_no}}</td>
                    <td>{{$jc->job_title}}</td>
                    <td>{{$jc->job_type->name}}</td>
                    <td>{{$jc->customer->customer_name}}</td>
                    <td>{{$jc->contact_person}}</td>
                    <td>{{$jc->delivery_date}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
