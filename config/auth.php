<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
     */

    'defaults'  => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
     */

    'guards'    => [
        'web'   => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],

        'api'   => [
            'driver'   => 'sanctum',
            'provider' => 'users',
        ],
        'admin-api'   => [
            'driver'   => 'sanctum',
            'provider' => 'admins',
        ],
        'agency_user' => [
            'driver' => 'session',
            'provider' => 'agency_users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
     */

    'providers' => [
        'users'  => [
            'driver' => 'eloquent',
            'model'  => SCart\Core\Front\Models\ShopCustomer::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model'  => SCart\Core\Admin\Models\AdminUser::class,
        ],
        'agency_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\AgencyUser::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
     */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => env('DB_PREFIX', '').'shop_password_resets',
            'expire'   => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table'    => env('DB_PREFIX', '').'admin_password_resets',
            'expire'   => 60,
        ],
        'agency_users' => [
            'provider' => 'agency_user',
            'table'    => 'agency_users',
            'expire'   => 60,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

    'verification' => 60,

];
