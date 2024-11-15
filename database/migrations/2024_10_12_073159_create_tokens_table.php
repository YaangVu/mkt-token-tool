<?php

use App\Constants\TokenStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('purchase_token');
            $table->json('original_json')->nullable();
            $table->text('signature')->nullable();
            $table->string('order_id')->nullable();
            $table->foreignId('owner_id')->constrained()->on('users')->onDelete('cascade');
            $table->foreignId('created_by')->constrained()->on('users')->onDelete('cascade');
            $table->foreignId('sku_id')->constrained()->onDelete('cascade');
            $table->bigInteger('team_id')->nullable();
            $table->enum('status', [TokenStatuses::NEW, TokenStatuses::DUMPED, TokenStatuses::DUMPED_SUCCESS, TokenStatuses::DUMPED_FAILED])->default(TokenStatuses::NEW);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
