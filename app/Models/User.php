<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'full_name',
        'username',
        'password_hash',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password_hash' => 'hashed',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function cashRequests()
    {
        return $this->hasMany(CashRequest::class, 'requester_user_id');
    }

    public function approvedRequests()
    {
        return $this->hasMany(CashRequest::class, 'approver_user_id');
    }

    public function createdMovements()
    {
        return $this->hasMany(VaultMovement::class, 'created_by_user_id');
    }

    public function releasedMovements()
    {
        return $this->hasMany(VaultMovement::class, 'released_by_user_id');
    }

    public function receivedMovements()
    {
        return $this->hasMany(VaultMovement::class, 'received_by_user_id');
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->role_name === $roleName;
    }

    public function hasAnyRole($roles)
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }
        
        return $this->role && in_array($this->role->role_name, $roles);
    }
}