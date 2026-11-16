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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('surname', 100);
            $table->string('name', 100);
            $table->string('patronymic', 100)->nullable();
            $table->string('gender', 10);
            $table->date('birth_date');
            $table->string('phone', 30);
            $table->string('address', 255);
            $table->string('email', 255);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
