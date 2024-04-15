<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AgencyUser extends Model implements Authenticatable
{
    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'username', 'password', 'email', 'agency_id', 'agency_level'
    ];

    /**
     * @var string
     */
    protected $guard = 'agency_user';

    /**
     * @var bool
     */
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @return BelongsTo
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    /**
     * @return HasMany
     */
    public function commissions()
    {
        return $this->hasMany(AgencyCommission::class, 'agency_user_id', 'id');
    }

    /**
     * @param $uuid
     * @return mixed $user
     */
    public static function findByUuidOrFail($uuid)
    {
        $user = static::where('agency_id', $uuid)->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return $user;
    }

    /**
     * @param $credentials
     * @return bool
     */
    public function validateCredentials($credentials)
    {
        return Hash::check($credentials['password'], $this->getAuthPassword());
    }
    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
    }

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
