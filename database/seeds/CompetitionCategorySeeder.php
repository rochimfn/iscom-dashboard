<?php

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
                'competition_category_abbreviation' => 'dpp'
            ],
            [
                'competition_category_name' => 'Bisnis TIK',
                'competition_category_abbreviation' => 'bistik'
            ],
            [
                'competition_category_name' => 'Kota Cerdas',
                'competition_category_abbreviation' => 'kc'
            ],
            [
                'competition_category_name' => 'Pengembangan Perangkat Lunak',
                'competition_category_abbreviation' => 'ppl'
            ],
            [
                'competition_category_name' => 'Pengembangan Aplikasi Game',
                'competition_category_abbreviation' => 'pag'
            ],
            [
                'competition_category_name' => 'Visualisasi Data',
                'competition_category_abbreviation' => 'visdat'
            ],
            [
                'competition_category_name' => 'Pemrograman Kompetitif Dasar',
                'competition_category_abbreviation' => 'cc'
            ]
        ];

        DB::table('competition_categories')->insert($competitionCategories);
    }
}
