<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\RankMember\Entities\RankMember;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'avatar',
        'user_type',
        'client_specific_field',
        'user_specific_field',
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
    ];
    public function scopeSearch(Builder $query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function scopeFilter(Builder $query, $filter)
    {
        if (!empty($filter)) {
            return $query->where('rank_member_id', $filter);
        }

        return $query;
    }

    public function scopeSort(Builder $query, $sort, $direction)
    {
        if (!$sort) {
            $sort = 'created_at'; // Mặc định sắp xếp theo created_at nếu không có cột được chỉ định
        }
        return $query->orderBy($sort, $direction);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Lấy rank mặc định
            $defaultRank = RankMember::where('min_points', 0)->first();

            // Đặt rank mặc định cho người dùng mới
            $user->rank_member_id = $defaultRank->id;
        });
    }

    public function isClient()
    {
        return $this->user_type === 'client';
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

     // Scope để lọc user có user_type là 'admin'
     public function scopeOnlyAdmins($query)
     {
         return $query->where('user_type', 'admin');
     }

      // Scope để lọc user có user_type là 'client'
      public function scopeOnlyClients($query)
      {
          return $query->where('user_type', 'client');
      }

       public function rankMember()
    {
        return $this->belongsTo(RankMember::class, 'rank_member_id');
    }
}
