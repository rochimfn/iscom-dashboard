<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
        	[
        		'user_id' => 1,
        		'page_title' => 'Kategori',
        		'page_content' => '<p>Ini halaman kategori</p>',
        		'slug' => 'kategori',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'user_id' => 1,
        		'page_title' => 'FAQ',
        		'page_content' => '<p>Ini halaman FAQ</p>',
        		'slug' => 'faq',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'user_id' => 1,
        		'page_title' => 'Tentang',
        		'page_content' => '<p>Ini halaman tentang</p>',
        		'slug' => 'tentang',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	]
        ];

        DB::table('pages')->insert($pages);
    }
}
