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
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile',11)->nullable();
            $table->string('tow_factor_code',4)->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('status')->default(false);
            $table->dateTime('email_verified_at')->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')->cascadeOnDelete();
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
