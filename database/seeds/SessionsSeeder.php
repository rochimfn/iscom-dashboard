<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sessions = [
        	[
        		'session_name' => 'registration',
        		'session_start' => Carbon::now(),
        		'session_end' => Carbon::now()
        	],
        	[
        		'session_name' => 'kti_submit',
        		'session_start' => Carbon::now(),
        		'session_end' => Carbon::now()
        	],
        	[
        		'session_name' => 'non_kti_submit',
        		'session_start' => Carbon::now(),
        		'session_end' => Carbon::now()
        	]
        ];

        DB::table('sessions')->insert($sessions);
    }
}
