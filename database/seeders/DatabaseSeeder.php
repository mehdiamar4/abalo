<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AbTestDataSeeder::class,
            DevelopmentData::class,
        ]);
        $this->call(ArticleHasArticleCategorySeeder::class);
    }
}
