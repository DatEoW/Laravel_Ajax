<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ADMIN = 0;
    const EDITOR = 1;
    const REVIEWER = 2;
    protected $table = 'mst_users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'is_active',
        'is_delete',
        'group_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // sử dụng appends kết hợp với mutators để tạo ra các biến mới k nằm trong database
    protected $appends = ['group_text', 'active_text'];

    /**
     * Thêm mới giá trị group_text mỗi khi đọc dữ liệu và chuyển đổi group_text dựa trên group_role
     * @param  number
     * @return string
     */
    public function getGroupTextAttribute()
    {
        $group_text = '';

        if ($this->group_role == 0) {
            $group_text = '<p class="text-primary fw-bold">Admin</p>';
        } elseif ($this->group_role == 1) {
            $group_text = 'Editor';
        } elseif ($this->group_role == 2) {
            $group_text = 'Reviewer';
        }
        return $group_text;
    }
    /**
     * Thêm mới giá trị active_text mỗi khi đọc dữ liệu và chuyển đổi active_text dựa trên is_active
     * @param  number
     * @return string
     */
    public function getActiveTextAttribute()
    {
        $active_text = '';

        if ($this->is_active == 0) {
            $active_text = '<p class="text-danger fw-bold">Tạm Khóa</p>';
        } elseif ($this->is_active == 1) {
            $active_text = '<p class="text-success">Hoạt Động</p>';
        }
        return $active_text;
    }

    /**
     * xử lý query theo name
     * @param  $query
     * @param $name
     * @return string|void
     */
    public function scopeByName($query, $name = ''): void
    {
        if (!empty($name) || $name == 0) {
            $query->where('name', 'like', "%$name%");
        }
    }
    /**
     * xử lý query theo is_active
     * @param  $query
     * @param $is_active
     * @return string|void
     */
    public function scopeActive($query, $is_active = 2): void
    {
        if (isset($is_active) && $is_active != 2) {
            $query->where('is_active', $is_active);
        }
    }
    /**
     * xử lý query theo email
     * @param  $query
     * @param $email
     * @return string|void
     */
    public function scopeByEmail($query, $email = ''): void
    {
        if (!empty($email) || $email == 0) {
            $query->where('email', 'like', "%$email%");
        }
    }
    /**
     * xử lý query theo group_role
     * @param  $query
     * @param $group_role
     * @return string|void
     */
    public function scopeByGroupRole($query, $group_role = 2): void
    {
        if (isset($group_role) && ($group_role != 3)) {
            $query->where('group_role', $group_role);
        }
    }
}
