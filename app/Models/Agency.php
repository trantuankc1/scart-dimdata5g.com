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

    public function commission()
    {
        return $this->hasOne(AgencyCommission::class, 'agency_id');
    }

    public function relations()
    {
        return $this->belongsToMany(Agency::class, 'agency_relations', 'parent_agency_id', 'child_agency_id');
    }
}
