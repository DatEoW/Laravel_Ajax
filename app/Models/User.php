<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
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
    const NOSEARCHROLE = 3;
    const ACTIVE = 1;
    const NOTACTIVE = 0;
    const NOSEARCHACTIVE = 2;
    const DELETED = 1;
    const NOTDELETE = 0;
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
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }





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

        if ($this->group_role == User::ADMIN) {
            $group_text = '<p class="text-primary fw-bold">Admin</p>';
        } elseif ($this->group_role == User::EDITOR) {
            $group_text = 'Editor';
        } elseif ($this->group_role == User::REVIEWER) {
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

        if ($this->is_active == User::NOTACTIVE) {
            $active_text = '<p class="text-danger fw-bold">Tạm Khóa</p>';
        } elseif ($this->is_active == User::ACTIVE) {
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
    public function scopeActive($query, $is_active = User::NOSEARCHACTIVE): void
    {
        if (isset($is_active) && $is_active != User::NOSEARCHACTIVE) {
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
    public function scopeByGroupRole($query, $group_role = User::NOSEARCHROLE): void
    {
        if (isset($group_role) && ($group_role != User::NOSEARCHROLE)) {
            $query->where('group_role', $group_role);
        }
    }
}
