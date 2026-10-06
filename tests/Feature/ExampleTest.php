<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_articles_can_be_filtered_by_category(): void
    {
        DB::table('ab_user')->insert([
            'id' => 1,
            'ab_name' => 'seller',
            'ab_password' => 'test',
            'ab_mail' => 'seller@example.com',
        ]);

        DB::table('ab_articlecategory')->insert([
            ['id' => 2, 'ab_name' => 'Autos'],
            ['id' => 10, 'ab_name' => 'Smartphones'],
        ]);

        DB::table('ab_article')->insert([
            [
                'id' => 1,
                'ab_name' => 'Testauto',
                'ab_price' => 5000,
                'ab_description' => 'Ein Auto für den Test',
                'ab_creator_id' => 1,
                'ab_createdate' => now(),
            ],
            [
                'id' => 2,
                'ab_name' => 'Testtelefon',
                'ab_price' => 300,
                'ab_description' => 'Ein Telefon für den Test',
                'ab_creator_id' => 1,
                'ab_createdate' => now(),
            ],
        ]);

        DB::table('ab_article_has_articlecategory')->insert([
            ['ab_articlecategory_id' => 2, 'ab_article_id' => 1],
            ['ab_articlecategory_id' => 10, 'ab_article_id' => 2],
        ]);

        $this->get('/?category=2')
            ->assertOk()
            ->assertSee('Testauto')
            ->assertDontSee('Testtelefon');
    }

    public function test_create_article_page_returns_a_successful_response(): void
    {
        $this->get('/newarticle')
            ->assertOk()
            ->assertSee('Artikel einstellen');
    }
}
