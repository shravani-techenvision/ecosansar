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
        Schema::create('reusable_item_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile', 20);
            $table->integer('quantity');
            $table->string('lid_colour')->nullable();
            $table->string('delivery_place');
            $table->date('required_by_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reusable_item_enquiries');
    }
};
