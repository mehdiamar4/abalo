<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleHasArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/article_has_articlecategory.csv');

        if (!file_exists($path)) {
            echo "CSV file not found: " . $path . PHP_EOL;
            return;
        }

        $file = fopen($path, 'r');

        // first row = header, skip it
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            DB::table('ab_article_has_articlecategory')->updateOrInsert(
                [
                    'ab_articlecategory_id' => (int) $row[0],
                    'ab_article_id' => (int) $row[1],
                ],
                []
            );
        }

        fclose($file);
    }
}
