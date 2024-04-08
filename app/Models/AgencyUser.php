<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AgencyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'password', 'email', 'agency_id', 'agency_level'
    ];

    public $incrementing = false; // Đặt giá trị này thành false để Laravel không cố gắng tự động tăng trường id

    protected $keyType = 'string'; // Đặt kiểu dữ liệu cho trường id


    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function commission()
    {
        return $this->hasOne(AgencyCommission::class, 'agency_id');
    }
    public static function findByUuidOrFail($uuid)
    {
        $user = static::where('agency_id', $uuid)->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return $user;
    }
}
