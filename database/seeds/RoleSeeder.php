<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role_name' => 'admin'
            ],
            [
                'role_name' => 'mahasiswa'
            ],
            [
                'role_name' => 'dosen'
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
