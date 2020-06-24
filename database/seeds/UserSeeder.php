<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
        	[
        		'user_name' => 'administrator',
        		'email' => 'rochim@localhost',
        		'user_role_id' => 1,
        		'password' => Hash::make('passworddefault')
        	]
        ];

        DB::table('users')->insert($user);
    }
}
