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
        Schema::create('post_languages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 160);
            $table->string('content')->nullable();
            $table->unsignedInteger('post_id');
            $table->foreignId('language_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_languages');
    }
};
