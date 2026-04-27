<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentData extends Seeder
{
    public function run(): void
    {
        $this->loadUsers();
        $this->loadCategories();
        $this->loadArticles();
    }

    private function loadUsers(): void
    {
        $file = fopen(database_path('data/user.csv'), 'r');

        // First line = header, we skip it
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            DB::table('ab_user')->insert([
                'id' => (int) $row[0],
                'ab_name' => $row[1],
                'ab_password' => $row[2],
                'ab_mail' => $row[3],
            ]);
        }

        fclose($file);
    }

    private function loadCategories(): void
    {
        $file = fopen(database_path('data/articlecategory.csv'), 'r');

        // First line = header, we skip it
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            DB::table('ab_articlecategory')->insert([
                'id' => (int) $row[0],
                'ab_name' => $row[1],
                'ab_description' => $this->emptyToNull($row[2]),
                'ab_parent' => $this->emptyToNull($row[3] ?? null),
            ]);
        }

        fclose($file);
    }

    private function loadArticles(): void
    {
        $file = fopen(database_path('data/articles.csv'), 'r');

        // First line = header, we skip it
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            DB::table('ab_article')->insert([
                'id' => (int) $row[0],
                'ab_name' => $row[1],
                'ab_price' => $this->convertPrice($row[2]),
                'ab_description' => $row[3],
                'ab_creator_id' => (int) $row[4],
                'ab_createdate' => $this->convertDate($row[5]),
            ]);
        }

        fclose($file);
    }

    private function emptyToNull($value)
    {
        if ($value === '' || $value === null) {
            return null;
        }

        return $value;
    }
    private function convertDate(string $value): string

    {

        $date = \DateTime::createFromFormat('d.m.y H:i', $value);

        return $date->format('Y-m-d H:i:s');

    }
    private function convertPrice(string $value): int
    {
        $value = trim($value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (int) round(((float) $value) * 100);
    }
}
