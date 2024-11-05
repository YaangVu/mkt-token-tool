<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('teamables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('teamable_type');
            $table->bigInteger('teamable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teamables');
        Schema::dropIfExists('teams');
    }
};
