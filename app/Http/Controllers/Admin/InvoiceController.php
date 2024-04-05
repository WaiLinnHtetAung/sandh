<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\InvoiceParticular;
use App\Models\JobCard;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.invoices.index');
    }

    public function invoiceLists()
    {
       $data = Invoice::with('customer');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })

            ->editColumn('customer_id', function($each) {
                return $each->customer->customer_name;
            })

            ->filterColumn('customer_id', function($query, $keyword) {
                $query->whereHas('customer', function($q) use ($keyword) {
                    $q->where('customer_name', 'like', "%$keyword%");
                });
            })

            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $del_icon = '';

                $edit_icon = '<a href="' . route('admin.invoices.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        $jobCards = JobCard::where('is_active', 1)->get();
        $customers = Customer::where('is_active', 1)->get();
        $current_date = date('Y-m-d');

        return view('admin.invoices.create', compact('jobCards','customers', 'current_date'));
    }

    public function getCustomerInfo(Request $request) {
        $id = $request->id;
        if($id) {
            $customer = JobCard::with('customer')->findOrFail($id);

            return $customer;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            $invoice = new Invoice();
            $invoice->invoice_no = '# ' . sprintf("%04d", Invoice::max('id') ? Invoice::max('id') + 1 : 1);
            $invoice->voucher_no = $request->voucher_no;
            $invoice->date = $request->date;
            $invoice->job_card_id = $request->job_card_id;
            $invoice->customer_id = $request->customer_id;
            $invoice->total = $request->total;
            $invoice->advance = $request->advance;
            $invoice->balance = $request->balance;
            $invoice->save();

            for ($i=0; $i < count($request->particular); $i++) {
                $invoiceParticular = new InvoiceParticular();
                $invoiceParticular->invoice_id = $invoice->id;
                $invoiceParticular->particular_name = $request->particular[$i];
                $invoiceParticular->qty = $request->qty[$i];
                $invoiceParticular->rate = $request->rate[$i];
                $invoiceParticular->amount = $request->amount[$i];
                $invoiceParticular->save();
            }

            DB::commit();
            session()->flash('success', 'Successfully Created');
            return 'success';

        } catch(\Exception $error) {
            logger($error->getMessage());
            DB::rollBack();
            return response()->json(['error' => $error->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $jobCards = JobCard::where('is_active', 1)->get();
        $customers = Customer::where('is_active', 1)->get();
        $current_date = $invoice->date;
        $invoice = $invoice->load('customer', 'job_card', 'particulars');

        return view('admin.invoices.edit', compact('jobCards', 'customers', 'current_date', 'invoice'));
    }

    public function printInvoice($id) {
        $invoice = Invoice::with('customer', 'job_card', 'particulars')->findOrFail($id);
        $jobCards = JobCard::where('is_active', 1)->get();
        $customers = Customer::where('is_active', 1)->get();
        $current_date = $invoice->date;

        return view('admin.invoices.print', compact('invoice', 'jobCards', 'customers', 'current_date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
