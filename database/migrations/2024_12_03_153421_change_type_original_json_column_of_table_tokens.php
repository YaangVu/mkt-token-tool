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
        // Change column type of original_json column from JSON to TEXT in tokens table
        Schema::table('tokens', function (Blueprint $table) {
            $table->text('original_json')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rollback the change of column type of original_json column from TEXT to JSON in tokens table
        Schema::table('tokens', function (Blueprint $table) {
            $table->json('original_json')->nullable()->change();
        });
    }
};
