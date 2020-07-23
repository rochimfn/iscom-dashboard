<?php

use Carbon\Carbon;
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
        		'user_name' => 'adminnich',
        		'email' => 'rochim@localhost',
        		'user_role_id' => 1,
        		'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        	]
        ];

        DB::table('users')->insert($user);
    }
}
