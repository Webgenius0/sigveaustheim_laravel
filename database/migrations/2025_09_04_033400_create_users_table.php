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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['teacher', 'admin'])->nullable();
            $table->string('email', 100)->nullable();
            $table->string('avatar')->nullable();

            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();

            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_token_expire_at')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_email_verified')->default(false);
            $table->string('verification_token')->nullable()->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
