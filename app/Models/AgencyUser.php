<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'password', 'email', 'agency_id'
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }


}
