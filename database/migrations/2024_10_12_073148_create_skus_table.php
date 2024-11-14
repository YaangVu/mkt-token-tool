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
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('game_name')->nullable();
            $table->string('package_name')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('price_currency_code')->default('USD')->nullable();
            $table->string('product_id')->unique();
            $table->string('type')->nullable()->default('inapp');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->bigInteger('team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};
