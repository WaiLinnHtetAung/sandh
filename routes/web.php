<?php

use App\Http\Controllers\Admin\CompleteJobCardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\JobCardController;
use App\Http\Controllers\Admin\JobCardDeliveryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Route::get('/', function () {return redirect()->route('admin.home');});

Route::group(['middleware' => ['auth', 'prevent-back-history'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('home');

    //permission
    Route::get('/permission-datatable', [PermissionController::class, 'dataTable']);
    Route::resource('permissions', PermissionController::class);

    //roles
    Route::get('/roles-datatable', [RolesController::class, 'dataTable']);
    Route::resource('roles', RolesController::class);

    //users
    Route::get('/users-datatable', [UserController::class, 'dataTable']);
    Route::resource('users', UserController::class);

    Route::group(['prefix' => 'job'], function() {
        //job card
        Route::get('/job-cards-list', [JobCardController::class, 'jobCardList']);
        Route::get('/job-cards/create-job-type', [JobCardController::class, 'createJobType']);
        Route::get('/job-cards/create-customer', [JobCardController::class, 'createCustomer']);
        Route::post('/job-cards/update/{job_card}', [JobCardController::class, 'updateJobCard']);
        Route::get('job-cards/date-range/filter', [JobCardController::class, 'dateRangeFilter']);
        Route::resource('job-cards', JobCardController::class);

        // delivery
        Route::get('delivery-list', [JobCardDeliveryController::class, 'deliveryList']);
        Route::get('delivery/complete', [JobCardDeliveryController::class, 'completeJobCard']);
        Route::resource('delivery', JobCardDeliveryController::class);

        //complete
        Route::get('complete-job-cards-list', [CompleteJobCardController::class, 'completeJobList']);
        Route::resource('complete-job-cards', CompleteJobCardController::class);

        //invoice
        Route::get('invoices-list', [InvoiceController::class, 'invoiceLists']);
        Route::get('/invoices/get-customer-info', [InvoiceController::class, 'getCustomerInfo']);
        Route::get('/invoices/print/{id}', [InvoiceController::class, 'printInvoice'])->name('invoice.print');
        Route::resource('invoices', InvoiceController::class);
    });
});

require __DIR__ . '/auth.php';
