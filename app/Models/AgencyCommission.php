<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'agency_id',
        'commission_rate',
        'agency_user_id'
    ];

    protected $table = 'agency_commissions';
    public function user()
    {
        return $this->belongsTo(AgencyUser::class, 'agency_user_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

}
