<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $table = 'agencies';
    protected $fillable = [
        'name'
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
