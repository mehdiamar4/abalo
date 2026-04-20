<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ab_testdata')->upsert(
            [
                [
                    'id' => 1,
                    'ab_testname' => 'Fotokamera',
                ],
                [
                    'id' => 2,
                    'ab_testname' => 'Blitzlicht',
                ],
            ],
            ['id'],
            ['ab_testname']
        );
    }
}
