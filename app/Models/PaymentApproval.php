<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentApproval extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'payment_id', 'payment_type', 'status'];

    /**
     * Get the parent paymentable model (payment or travelPayment).
     */
    public function paymentable()
    {
        return $this->morphTo('payment');
    }

    /**
	 * Filter approved payments
	 *
	 * @param Builder $query
	 * @return void
	 */
    public function scopeApproved($query)
    {
        $query->where('status', 'APPROVED');
    }
    
    /**
	 * Filter rejected payments
	 *
	 * @param Builder $query
	 * @return void
	 */
    public function scopeRejected($query)
    {
        $query->where('status', 'REJECTED');
    }
}
