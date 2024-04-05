<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function job_card() {
        return $this->belongsTo(JobCard::class, 'job_card_id', 'id');
    }

    public function particulars() {
        return $this->hasMany(InvoiceParticular::class);
    }
}
