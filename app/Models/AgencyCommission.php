<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'commission_rate',
    ];

    protected $table = 'agency_commissions';



    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

}
