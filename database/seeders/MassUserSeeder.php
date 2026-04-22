<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassUserSeeder extends Seeder
{
    public function run(): void
    {
        $startId = DB::table('ab_user')->max('id') + 1;

        for ($i = 0; $i < 10000; $i++) {
            DB::table('ab_user')->insert([
                'id' => $startId + $i,
                'ab_name' => 'mass_user_' . $i,
                'ab_password' => bcrypt('password'),
                'ab_mail' => 'mass_user_' . $i . '@example.com',
            ]);
        }
    }
}
