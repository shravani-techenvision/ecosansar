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
        Schema::create('google_adsenses', function (Blueprint $table) {
            $table->id();
             $table->string('place_of_adsense')->nullable();
             $table->string('adsense_script')->nullable();
             $table->string('adsense_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_adsenses');
    }
};
