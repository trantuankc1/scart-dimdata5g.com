<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyCommission extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

}
