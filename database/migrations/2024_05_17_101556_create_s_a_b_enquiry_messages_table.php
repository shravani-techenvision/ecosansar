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
        Schema::create('s_a_b_enquiry_messages', function (Blueprint $table) {
            $table->id();
            $table->string('login_id')->nullable();;
            $table->string('user_id')->nullable();;
            $table->string('post_id')->nullable();;
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('usermessage')->nullable();
            $table->string('adminmessage')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_b_enquiry_messages');
    }
};
