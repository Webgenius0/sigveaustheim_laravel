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
        Schema::create('fitness_test_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('fitness_tests')->onDelete('cascade');
            $table->integer('level')->unsigned()->comment('Level number (1 to 5)');
            $table->string('level_name', 50)->comment('E.g., Foundation, Participation');
            $table->integer('min_percentage')->unsigned()->comment('Minimum percentage for this level');
            $table->integer('max_percentage')->unsigned()->comment('Maximum percentage for this level');
            $table->text('comment')->comment('Dynamic comment for this level');
            $table->string('star_image')->comment('Path to star image');
            $table->timestamps();

            // Ensure unique level per test
            $table->unique(['test_id', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitness_test_lavels');
    }
};
