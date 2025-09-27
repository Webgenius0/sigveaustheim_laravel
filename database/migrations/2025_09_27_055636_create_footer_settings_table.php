<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->json('social_icons')->nullable();
            $table->string('help_center_pdf')->nullable();
            $table->string('privacy_policy_pdf')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        // Insert default row (optional)
        DB::table('footer_settings')->insert([
            'description' => 'Empowering schools to assess, track, and improve student fitness with scientifically designed tests and automated reporting.',
            'email' => 'support@example.com',
            'phone' => '+1834 123 456 789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
