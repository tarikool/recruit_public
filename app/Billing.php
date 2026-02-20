<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Billing extends Model
{
    use Notifiable;

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'issue_date',
        'invoice_code',
        'client_id',
        'is_notified',
        'notify_at',
        'sub_total_amount',
        'tax_amount',
        'total_amount',
        'due_amount',
        'created_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Single Bill can have multiple Jobs
     * @return HasMany
     */
    public function billing_jobs()
    {
        return $this->hasMany(BillingJob::class, 'billing_id', 'id');
    }

    public function getPaymentStatus()
    {
        $paymentStatus = false;
        if ($this->due_amount == 0){
            $paymentStatus = true;
        }
        return $paymentStatus;
    }
}
