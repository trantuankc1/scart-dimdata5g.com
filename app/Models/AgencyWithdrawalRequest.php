<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyWithdrawalRequest extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'agency_withdrawal_requests';

    /**
     * @var string[]
     */
    protected $fillable = [
        'agency_user_id',
        'bank_name',
        'bank_account_number',
        'amount',
        'status'
    ];

    public function agencyUser()
    {
        return $this->belongsTo(AgencyUser::class);
    }
}
