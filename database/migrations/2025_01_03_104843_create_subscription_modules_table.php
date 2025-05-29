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
        Schema::create('subscription_modules', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name')->nullable();
            $table->integer('plan_price')->nullable();
            $table->string('plan_validity')->nullable();
            $table->text('plan_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_modules');
    }
};
