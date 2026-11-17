<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fin_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fin_category_id')->constrained('fin_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('announce');
            $table->text('body');
            $table->date('published_at');
            $table->text('search'); // заголовок, анонс и текст в нижнем регистре для поиска
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fin_articles');
    }
};
