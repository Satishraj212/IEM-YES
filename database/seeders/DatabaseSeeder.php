<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ─────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@yes-iem.com'],
            [
                'name'     => 'YES IEM Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'status'   => 'active',
            ]
        );

        // ── Demo branch + branch admin ─────────────────────────────────────────
        $branch = Branch::updateOrCreate(
            ['code' => 'UTM-JB'],
            [
                'name'        => 'YES UTM Johor',
                'institution' => 'Universiti Teknologi Malaysia',
                'location'    => 'Johor Bahru',
                'state'       => 'Johor',
                'status'      => 'active',
                'is_active'   => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'branch@yes-iem.com'],
            [
                'name'      => 'Branch Admin Demo',
                'password'  => Hash::make('password'),
                'branch_id' => $branch->id,
                'role'      => 'branch_admin',
                'status'    => 'active',
            ]
        );

        $this->call(AdminSeeder::class);
    }
}
