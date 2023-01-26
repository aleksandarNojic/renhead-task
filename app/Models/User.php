<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const APPROVER = 'APPROVER';

    const TYPES = [
        self::APPROVER,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The payments that belongs to the user.
     */
    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }

    /**
     * The travelPayments that belongs to the user.
     */
    public function travelPayments()
    {
        return $this->hasMany(
            TravelPayment::class
        );
    }

    /**
     * The paymentApprovals that belongs to the user.
     */
    public function paymentApprovals()
    {
        return $this->hasMany(
            PaymentApproval::class
        );
    }

    /**
     * Check if has privilege
     */
    public function hasPrivilege(string $privilege)
    {
        return $this->type === $privilege;
    }
}
