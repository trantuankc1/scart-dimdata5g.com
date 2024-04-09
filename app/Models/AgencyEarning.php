<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_user_id',
        'total_profit',
    ];

    protected $table  = 'agency_earnings';

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }
}
