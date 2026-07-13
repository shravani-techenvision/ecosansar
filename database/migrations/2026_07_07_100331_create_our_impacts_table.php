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
        Schema::create('our_impacts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('count');
            $table->string('suffix')->default('+');
            $table->text('description');
            $table->integer('display_order')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_impacts');
    }
};
