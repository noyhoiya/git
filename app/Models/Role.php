<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';
    
    protected $fillable = [
        'role_name',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public static function getAvailableRoles()
    {
        return [
            'MAIN_VAULT' => 'Main Vault Operator',
            'TELLER' => 'Teller',
            'ADMIN_VAULT' => 'Admin Vault Operator', 
            'AUDITOR' => 'Auditor',
            'ADMIN' => 'System Administrator'
        ];
    }
}