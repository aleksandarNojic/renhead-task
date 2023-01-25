<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentApproval extends Model
{
    use SoftDeletes;

    const APPROVED = "APPROVED";
    const DISAPPROVED = 'DISAPPROVED';

    const STASUES = [
        self::APPROVED,
        self::DISAPPROVED
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status'
    ];

    /**
     * Get the parent payment model (payment or travelPayment).
     */
    public function payment()
    {
        return $this->morphTo();
    }
}
