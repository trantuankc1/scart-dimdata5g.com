<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyProfit extends Model
{
    use HasFactory;

    protected $table = 'agency_profits';

    protected $fillable = [
        'agency_id',
        'total_profit',
        'last_updated_at'
    ];

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'agency_id', 'uuid');
    }
}
