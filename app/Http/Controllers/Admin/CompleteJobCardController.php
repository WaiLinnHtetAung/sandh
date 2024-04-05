<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class CompleteJobCardController extends Controller
{
    public function index() {
        return view('admin.complete_job_card.index');
    }

    public function completeJobList(Request $request)
    {
        $data = JobCard::with('job_type', 'customer')->where('is_complete', 1);

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

            ->addColumn('status', function ($each) {
                $status = "<span class='badge rounded-pill bg-success'>completed</span>";

                return $status;
            })
            ->rawColumns(['status'])
            ->make(true);

    }
}
