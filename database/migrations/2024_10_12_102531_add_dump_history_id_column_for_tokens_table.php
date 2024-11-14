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
        Schema::table('tokens', function (Blueprint $table) {
            $table->foreignId('dump_history_id')->nullable()->constrained('token_dump_histories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropForeign(['dump_history_id']);
            $table->dropColumn('dump_history_id');
        });
    }
};
