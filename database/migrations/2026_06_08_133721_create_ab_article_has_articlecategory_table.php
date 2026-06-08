<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ab_article_has_articlecategory')) {
            Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
                $table->unsignedBigInteger('ab_articlecategory_id');
                $table->unsignedBigInteger('ab_article_id');

                $table->primary(['ab_articlecategory_id', 'ab_article_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
