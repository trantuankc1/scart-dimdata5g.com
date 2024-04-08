<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyRelation extends Model
{
    use HasFactory;

    protected $table = 'agency_relations';

    protected $fillable = [
        'parent_agency_id',
        'child_agency_id',
    ];

    public function parentAgency()
    {
        return $this->belongsTo(Agency::class, 'parent_agency_id');
    }

    public function childAgency()
    {
        return $this->belongsTo(Agency::class, 'child_agency_id');
    }
}
