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
        Schema::create('token_dump_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('sku_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->bigInteger('team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_dump_histories');
    }
};
