<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingJob extends Model
{

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'billing_id',
        'job_id',
        'bill_amount',
        'discount_amount',
        'remarks',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function subTotalAmount()
    {
        return ($this->bill_amount-$this->discount_amount);
    }
}
