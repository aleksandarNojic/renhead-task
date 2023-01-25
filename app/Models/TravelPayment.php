<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelPayment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount'
    ];

    /**
     * The approval that belong to the payment.
     */
    public function approval()
    {
        return $this->morphOne(PaymentApproval::class, 'payment');
    }

    /**
     * The user that belong to the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
