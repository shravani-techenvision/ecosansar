<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('download_poster_enquiries', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('download_poster_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('name');
            $table->string('email');
            $table->string('mobile',20);
            $table->string('organization');

            $table->timestamps();

            $table->foreign('download_poster_id')
                ->references('id')
                ->on('download_posters')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('ecosansar_users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('download_poster_enquiries');
    }
};