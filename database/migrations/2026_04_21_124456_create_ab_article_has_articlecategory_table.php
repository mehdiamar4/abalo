<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ab_articlecategory_id');
            $table->unsignedBigInteger('ab_article_id');

            $table->unique([
                'ab_articlecategory_id',
                'ab_article_id'
            ]);

            $table->foreign('ab_articlecategory_id')
                ->references('id')
                ->on('ab_articlecategory')
                ->cascadeOnDelete();

            $table->foreign('ab_article_id')
                ->references('id')
                ->on('ab_article')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
