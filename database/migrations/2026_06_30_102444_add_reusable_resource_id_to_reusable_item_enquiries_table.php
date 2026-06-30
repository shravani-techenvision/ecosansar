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
        Schema::table('reusable_item_enquiries', function (Blueprint $table) {

            $table->unsignedBigInteger('reusable_resource_id')->after('id');
            $table->unsignedBigInteger('user_id')->after('reusable_resource_id');

            $table->foreign('reusable_resource_id')
                  ->references('id')
                  ->on('reusable_resources')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('ecosansar_users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reusable_item_enquiries', function (Blueprint $table) {

            $table->dropForeign(['reusable_resource_id']);
            $table->dropForeign(['user_id']);

            $table->dropColumn(['reusable_resource_id', 'user_id']);
        });
    }
};