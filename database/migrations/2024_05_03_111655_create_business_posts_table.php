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
        Schema::create('business_posts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('sale_giveaway')->nullable();
            $table->string('resource_img')->nullable();
            $table->string('quantity')->nullable();
            $table->string('clean_unclean')->nullable();
            $table->string('packaged')->nullable();
            $table->string('post_pic')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_posts');
    }
};
