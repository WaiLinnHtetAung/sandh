<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobType;
use DataTables;
use App\Models\JobCard;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.job_card.index');
    }

    public function jobCardList(Request $request)
    {
        $status = $request->status;
        $date_range = $request->date_range;
        $start_date = substr($request->date_range, 0, 10);
        $end_date = substr($request->date_range, -10);

        $query = JobCard::with('job_type', 'customer');

        // Filter by status
        if ($status == 'complete') {
            $query->where('is_complete', 1);
        } elseif ($status == 'pending') {
            $query->where('is_complete', 0);
        } elseif($status == 'all') {
            $query->whereDate('delivery_date', now()->toDateString());
        }

        // Filter by date range if provided
        if ($date_range) {
            $query->whereBetween('delivery_date', [$start_date, $end_date]);
        }

        // Fetch filtered data for DataTables
        $data = $query;

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })

            ->editColumn('job_type_id', function($each) {
                return $each->job_type->name;
            })

            ->editColumn('customer_id', function($each) {
                return $each->customer->customer_name;
            })

            ->filterColumn('job_type_id', function($query, $keyword) {
                $query->whereHas('job_type', function($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })

            ->filterColumn('customer_id', function($query, $keyword) {
                $query->whereHas('customer', function($q) use ($keyword) {
                    $q->where('customer_name', 'like', "%$keyword%");
                });
            })

            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $del_icon = '';

                $edit_icon = '<a href="' . route('admin.job-cards.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';

                return '<div class="action-icon">'  . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_active', 1)->get();
        $jobTypes = JobType::where('is_active', 1)->get();

        return view('admin.job_card.create', compact('customers', 'jobTypes'));
    }

    public function createJobType(Request $request) {

        $jobType = new JobType();
        $jobType->name = $request->job_type_name;
        $jobType->save();

        return $jobType;
    }

    public function createCustomer(Request $request) {

        $customer = new Customer();
        $customer->customer_code = '# ' . sprintf("%04d", Customer::max('id') ? Customer::max('id') + 1 : 1);
        $customer->customer_name = $request->customer_name ?? '';
        $customer->phone_no = $request->customer_phone ?? '';
        $customer->email = $request->customer_email ?? '';
        $customer->address = $request->address ?? '';
        $customer->save();

        return $customer;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jobCard = new JobCard();
        $jobCard->job_card_no =  '# ' . sprintf("%04d", JobCard::max('id') ? JobCard::max('id') + 1 : 1);
        $jobCard->job_title = $request->job_title;
        $jobCard->job_type_id = $request->job_type_id;
        $jobCard->customer_id = $request->customer_id;
        $jobCard->contact_person = $request->contact_person;
        $jobCard->contact_phone = $request->contact_phone;
        $jobCard->delivery_date = $request->delivery_date;
        $jobCard->remark = $request->remark;
        $jobCard->save();

        session()->flash('success', 'Successfully Created');
        return 'success';
    }

    /**
     * Display the specified resource.
     */
    public function show(JobCard $jobCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCard $jobCard)
    {
        $jobCard = $jobCard->load('job_type','customer');
        $customers = Customer::where('is_active', 1)->get();
        $jobTypes = JobType::where('is_active', 1)->get();

        return view('admin.job_card.edit', compact('jobCard', 'customers', 'jobTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateJobCard(Request $request, JobCard $jobCard)
    {
        $jobCard->job_title = $request->job_title;
        $jobCard->job_type_id = $request->job_type_id;
        $jobCard->customer_id = $request->customer_id;
        $jobCard->contact_person = $request->contact_person;
        $jobCard->contact_phone = $request->contact_phone;
        $jobCard->delivery_date = $request->delivery_date;
        $jobCard->remark = $request->remark;
        $jobCard->save();

        session()->flash('success', 'Successfully Edited');
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobCard $jobCard)
    {
        //
    }
}
