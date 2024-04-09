<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $table = 'agencies';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'lavel'
    ];

    public function users()
    {
        return $this->hasMany(AgencyUser::class, 'agency_id');
    }

    public function commissions()
    {
        return $this->hasMany(AgencyCommission::class, 'agency_id');
    }
}
