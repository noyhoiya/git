<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Vault;
use App\Models\Purpose;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            ['role_name' => 'MAIN_VAULT'],
            ['role_name' => 'TELLER'],
            ['role_name' => 'ADMIN_VAULT'],
            ['role_name' => 'AUDITOR'],
            ['role_name' => 'ADMIN'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create default admin user
        User::create([
            'full_name' => 'ຜູ້ບໍລິຫານລະບົບ',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role_id' => Role::where('role_name', 'ADMIN')->first()->role_id,
            'is_active' => true,
        ]);

        // Create Vaults
        $vaults = [
            ['vault_name' => 'ຕູ້ເງິນຫຼັກ', 'vault_type' => 'MAIN', 'current_balance_cents' => 10000000],
            ['vault_name' => 'ຕູ້ເງິນພະນັກງານ', 'vault_type' => 'SUB', 'current_balance_cents' => 0],
            ['vault_name' => 'ຕູ້ເງິນບໍລິຫານ', 'vault_type' => 'SUB', 'current_balance_cents' => 0],
        ];

        foreach ($vaults as $vault) {
            Vault::create($vault);
        }

        // Create Purposes
        $purposes = Purpose::getDefaultPurposes();
        foreach ($purposes as $code => $name) {
            Purpose::create([
                'purpose_code' => $code,
                'purpose_name' => $name,
            ]);
        }
    }
}