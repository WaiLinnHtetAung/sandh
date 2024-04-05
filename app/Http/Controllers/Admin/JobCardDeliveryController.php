<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\JobCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class JobCardDeliveryController extends Controller
{
    public function index() {
        return view('admin.job_card_delivery.index');
    }

    public function deliveryList(Request $request)
    {
        $status = $request->status;
        $date_range = $request->date_range;
        $start_date = substr($request->date_range, 0, 10);
        $end_date = substr($request->date_range, -10);

        $query = JobCard::with('job_type', 'customer')->where('is_complete', 0);

        // Filter by status
        if($status == 'today') {
            $query->whereDate('delivery_date', now()->toDateString());
        } elseif ($status == 'tomorrow') {
            $tomorrow = Carbon::tomorrow()->toDateString();
            $query->whereDate('delivery_date', $tomorrow);
        } elseif ($status == 'overmorrow') {
            $overmorrow = Carbon::tomorrow()->addDays(1)->toDateString();
            $query->whereDate('delivery_date', $overmorrow);
        } elseif($status == 'all') {
            $query;
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

            ->addColumn('complete', function ($each) {
                $status = "<i class='bx bxs-toggle-left fs-1 cursor-pointer complete-job-card' data-id='$each->id'></i>";
                return  $status;
            })
            ->rawColumns(['complete'])
            ->make(true);

    }

    public function completeJobCard(Request $request) {
        $id = $request->id;
        if($id) {
            $jobCard = JobCard::findOrFail($id);

            if($jobCard) {
                $jobCard->is_complete = 1;
                $jobCard->save();

                return 'success';
            }
        }
    }

}
