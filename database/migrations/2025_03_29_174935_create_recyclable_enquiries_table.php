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
        Schema::create('recyclable_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('post_user_id')->nullable();
            $table->string('post_id')->nullable();
            $table->string('login_user_id')->nullable();
            $table->string('flag')->nullable();
            $table->string('user_type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recyclable_enquiries');
    }
};
