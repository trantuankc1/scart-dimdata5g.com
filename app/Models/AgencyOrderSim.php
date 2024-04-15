<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyOrderSim extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'agency_order_sim';

    /**
     * @var string[]
     */
    protected $fillable = [
        'sim_type',
        'quantity',
        'delivery_address',
        'contact_email',
        'phone',
        'status',
    ];
}
