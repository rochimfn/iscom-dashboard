<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetitionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $competitionCategories = [
            [
                'competition_category_name' => 'Desain Pengalaman Pengguna',
                'competition_category_abbreviation' => 'dpp',
                'competition_category_team_limit' => 3,
                'is_kti' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'competition_category_name' => 'Bisnis TIK',
                'competition_category_abbreviation' => 'bistik',
                'competition_category_team_limit' => 3,
                'is_kti' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'competition_category_name' => 'Kota Cerdas',
                'competition_category_abbreviation' => 'kc',
                'competition_category_team_limit' => 3,
                'is_kti' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'competition_category_name' => 'Pengembangan Perangkat Lunak',
                'competition_category_abbreviation' => 'ppl',
                'competition_category_team_limit' => 3,
                'is_kti' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'competition_category_name' => 'Pengembangan Aplikasi Permainan',
                'competition_category_abbreviation' => 'pap',
                'competition_category_team_limit' => 3,
                'is_kti' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'competition_category_name' => 'Penambangan Data',
                'competition_category_abbreviation' => 'pd',
                'competition_category_team_limit' => 3,
                'is_kti' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'competition_category_name' => 'Pemrograman Kompetitif Dasar',
                'competition_category_abbreviation' => 'cc',
                'competition_category_team_limit' => 3,
                'is_kti' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('competition_categories')->insert($competitionCategories);
    }
}
