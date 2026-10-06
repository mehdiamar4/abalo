<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->seedUsers();
            $this->seedCategories();
            $this->seedArticles();
            $this->seedArticleCategories();
        });
    }

    private function rows(string $filename): array
    {
        $handle = fopen(database_path("data/{$filename}"), 'r');
        $headers = fgetcsv($handle, separator: ';');
        $rows = [];

        while (($values = fgetcsv($handle, separator: ';')) !== false) {
            $rows[] = array_combine($headers, $values);
        }

        fclose($handle);

        return $rows;
    }

    private function seedUsers(): void
    {
        foreach ($this->rows('user.csv') as $user) {
            DB::table('ab_user')->updateOrInsert(
                ['id' => (int) $user['id']],
                [
                    'ab_name' => $user['ab_name'],
                    'ab_password' => $user['ab_password'],
                    'ab_mail' => $user['ab_mail'],
                ]
            );
        }
    }

    private function seedCategories(): void
    {
        foreach ($this->rows('articlecategory.csv') as $category) {
            DB::table('ab_articlecategory')->updateOrInsert(
                ['id' => (int) $category['id']],
                [
                    'ab_name' => $category['ab_name'],
                    'ab_description' => null,
                    'ab_parent' => $category['ab_parent'] === 'NULL'
                        ? null
                        : (int) $category['ab_parent'],
                ]
            );
        }
    }

    private function seedArticles(): void
    {
        foreach ($this->rows('articles.csv') as $article) {
            DB::table('ab_article')->updateOrInsert(
                ['id' => (int) $article['id']],
                [
                    'ab_name' => $article['ab_name'],
                    'ab_price' => (int) str_replace('.', '', $article['ab_price']),
                    'ab_description' => $article['ab_description'],
                    'ab_creator_id' => (int) $article['ab_creator_id'],
                    'ab_createdate' => Carbon::createFromFormat('j.n.y H:i', $article['ab_createdate']),
                ]
            );
        }
    }

    private function seedArticleCategories(): void
    {
        foreach ($this->rows('article_has_articlecategory.csv') as $relation) {
            DB::table('ab_article_has_articlecategory')->updateOrInsert([
                'ab_articlecategory_id' => (int) $relation['ab_articlecategory_id'],
                'ab_article_id' => (int) $relation['ab_article_id'],
            ]);
        }
    }
}
