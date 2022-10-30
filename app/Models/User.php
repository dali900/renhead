<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'type',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
	 * PaymentApproval
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function paymentApprovals()
    {
        return $this->hasMany(PaymentApproval::class);
    }

    /**
	 * Filter users by type REGULAR
	 *
	 * @param Builder $query
	 * @return void
	 */
    public function scopeRegular($query)
    {
        $query->where('type', 'REGULAR');
    }
    
    /**
	 * Filter users by type REGULAR
	 *
	 * @param Builder $query
	 * @return void
	 */
    public function scopeApprover($query)
    {
        $query->where('type', 'APPROVER');
    }
}
