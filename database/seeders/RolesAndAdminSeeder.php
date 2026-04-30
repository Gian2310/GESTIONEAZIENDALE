<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('departments')->insert([
            ['name' => 'Amministrazione'],
            ['name' => 'Sviluppo'],
            ['name' => 'Vendite'],
        ]);

        DB::table('contracts')->insert([
            ['name' => 'Tempo Indeterminato', 'daily_hours' => 8, 'pause_minutes' => 30, 'vacation_days_per_year' => 26],
            ['name' => 'Part Time', 'daily_hours' => 4, 'pause_minutes' => 0, 'vacation_days_per_year' => 13],
        ]);

        // 2. Creazione Utente Amministratore (Admin)
        $adminDepartment = DB::table('departments')->where('name', 'Amministrazione')->first();
        $defaultContract = DB::table('contracts')->where('name', 'Tempo Indeterminato')->first();

        DB::table('users')->insert([
            'name' => 'Admin User',
            'first_name' => 'Marco',
            'last_name' => 'Rossi',
            'email' => 'admin@company.it',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin', // Ruolo Amministratore
            'fiscal_code' => 'MRCRSS00A01H501K',
            'base_salary' => 50000.00,
            'hiring_date' => '2020-01-01',
            'department_id' => $adminDepartment ? $adminDepartment->id : null,
            'contract_id' => $defaultContract ? $defaultContract->id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Creazione Utente Manager
        DB::table('users')->insert([
            'name' => 'Manager User',
            'first_name' => 'Laura',
            'last_name' => 'Bianchi',
            'email' => 'manager@company.it',
            'password' => Hash::make('password'), // Password: password
            'role' => 'manager',
            'fiscal_code' => 'LRABNC00A02H501B',
            'base_salary' => 35000.00,
            'hiring_date' => '2021-05-15',
            'department_id' => $adminDepartment ? $adminDepartment->id : null,
            'contract_id' => $defaultContract ? $defaultContract->id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
