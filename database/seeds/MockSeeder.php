<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        	[
	        	'user_name' => '052118400002',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	],
        	[
	        	'user_name' => '052118400003',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	],
        	[
	        	'user_name' => '052118400004',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	],
        	[
	        	'user_name' => '052118400005',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	],
        	[
	        	'user_name' => '052118400006',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	],
        	[
	        	'user_name' => '052118400007',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	],
        	[
	        	'user_name' => '052118400008',
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 2,
	        	'password' => Hash::make('password')
        	]
        ];


        $teams = [
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 1,
        	],
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 2,
        	],
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 3,
        	],
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 4,
        	],
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 5,
        	],
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 6,
        	],
        	[
        		'team_name' => Str::random(10),
        		'team_competition_category_id' => 7,
        	],
        ];

        $mahasiswa = [
        	[
        		'mahasiswa_nrp' => '052118400002',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 1,
        		'is_team_leader' => 1
        	],
        	[
        		'mahasiswa_nrp' => '052118400003',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 2,
        		'is_team_leader' => 1
        	],
        	[
        		'mahasiswa_nrp' => '052118400004',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 3,
        		'is_team_leader' => 1
        	],
        	[
        		'mahasiswa_nrp' => '052118400005',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 4,
        		'is_team_leader' => 1
        	],
        	[
        		'mahasiswa_nrp' => '052118400006',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 5,
        		'is_team_leader' => 1
        	],
        	[
        		'mahasiswa_nrp' => '052118400007',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 6,
        		'is_team_leader' => 1
        	],
        	[
        		'mahasiswa_nrp' => '052118400008',
        		'mahasiswa_name' => Str::random(25),
        		'mahasiswa_team_id' => 7,
        		'is_team_leader' => 1
        	]
        ];

        $questions = [
        	[
        		'question_competition_category_id' => 1,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	],
        	[
        		'question_competition_category_id' => 2,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	],
        	[
        		'question_competition_category_id' => 3,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	],
        	[
        		'question_competition_category_id' => 4,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	],
        	[
        		'question_competition_category_id' => 5,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	],
        	[
        		'question_competition_category_id' => 6,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	],
        	[
        		'question_competition_category_id' => 7,
        		'question_title' => Str::random(10),
        		'question_description' => Str::random(100)
        	]
        ];

        $users_dosen = [
        	[
        		'user_name' => Str::random(10),
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 3,
	        	'password' => Hash::make('password')
        	],
        	[
        		'user_name' => Str::random(10),
	        	'email' => Str::random(10). '@gmail.com',
	        	'user_role_id' => 3,
	        	'password' => Hash::make('password')
        	]
        ];
        $dosen = [
        	[
        		'dosen_name' => Str::random(20),
        		'dosen_user_id' => 9
        	],
        	[
        		'dosen_name' => Str::random(20),
        		'dosen_user_id' => 10
        	]
        ];

        DB::table('users')->insert($users);
        DB::table('teams')->insert($teams);
        DB::table('mahasiswa')->insert($mahasiswa);
        DB::table('questions')->insert($questions);

        DB::table('users')->insert($users_dosen);
        DB::table('dosen')->insert($dosen);
    }
}
