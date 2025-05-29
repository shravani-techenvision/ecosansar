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
        Schema::create('recyclable_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('post_id')->nullable();
            $table->string('login_user_id')->nullable();
             $table->string('title')->nullable();
            $table->string('rating')->nullable();
            $table->string('message')->nullable();
             $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recyclable_reviews');
    }
};
