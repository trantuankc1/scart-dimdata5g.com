<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $table = 'agencies';
    protected $fillable = [
        'name',
        'parent_id',
        'commission_rate',
    ];

    public function parent()
    {
        return $this->belongsTo(Agency::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Agency::class, 'parent_id');
    }
}
