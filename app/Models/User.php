<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'country_code',
        'mobile',
        'otp',
        'otp_verify',
        'device_type',
        'fcm_token',
        'profile_image',
        'banner_view',
        'lang',
        'notification',
        'app_notification',
        'selected_currency',
        'selected_country',
        'is_login',
        'is_visit_website',
        'is_visit_app',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


      public function country()
    {
        return $this->belongsTo(country::class, 'country_code', 'dial_code');
    }

    public function country_info()
    {
        return $this->belongsTo(all_countrie::class, 'country_code', 'dial_code');
    }

    public function wallet_info()
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }


      public function User_currency()
    {
        return $this->hasOne(all_countrie::class, 'id', 'selected_currency');
    }

}