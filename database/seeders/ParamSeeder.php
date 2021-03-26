<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('params')->insert([
            'category_param' => 'category_template',
            'param' => 'Islami',
            'order' => 1,
            'active' => 1,
        ]);

        DB::table('params')->insert([
            'category_param' => 'category_template',
            'param' => 'Kristiani',
            'order' => 2,
            'active' => 1,
        ]);

        DB::table('params')->insert([
            'category_param' => 'category_template',
            'param' => 'Hindu Bali',
            'order' => 3,
            'active' => 1,
        ]);

        DB::table('params')->insert([
            'category_param' => 'category_template',
            'param' => 'Nasional',
            'order' => 4,
            'active' => 1,
        ]);

        DB::table('params')->insert([
            'category_param' => 'category_template',
            'param' => 'Lainnya',
            'order' => 4,
            'active' => 1,
        ]);

        DB::table('params')->insert([
            'category_param' => 'category_template',
            'param' => 'Lainnya',
            'order' => 4,
            'active' => 1,
        ]);
    }
}
