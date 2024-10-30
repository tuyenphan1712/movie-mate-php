<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;  // Vô hiệu hóa auto-increment
    protected $keyType = 'string'; // Thiết lập kiểu khóa chính là chuỗi

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'gender',
        'password',
        'user_status',
    ];

    protected $casts = [
        'user_status' => UserStatus::class,
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Phương thức boot được gọi khi khởi tạo model, dùng để cấu hình các sự kiện
    protected static function boot()
    {
        parent::boot();

        // Tạo UUID tự động khi tạo một người dùng mới
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = Str::uuid()->toString();
            }
        });

        // Sự kiện "creating" được kích hoạt khi một user mới được tạo
        static::creating(function ($user) {
            // Đặt giá trị mặc định cho user_status là "active"
            $user->user_status = UserStatus::ACTIVE;
        });
    }
}
