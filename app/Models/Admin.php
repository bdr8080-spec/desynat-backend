<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'country_code',
        'mobile',
        'email',
        'password',
        'otp',
        'otp_verify',
        'device_type',
        'fcm_token',
        'type',
        'profile_pic',
        'country_id',
        'status',
        'unhashed_password',
        'notification',
        'app_notification',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    public function country_info()
    {
        return $this->belongsTo(country::class, 'country_id', 'id');
    }

    public function permission_details()
    {
        return $this->hasMany(AdminPermission::class, 'admin_id', 'id');
    }
}
