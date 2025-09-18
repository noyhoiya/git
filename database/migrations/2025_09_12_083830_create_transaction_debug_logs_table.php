<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction_debug_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_vault_id');
            $table->unsignedBigInteger('to_vault_id');
            $table->bigInteger('amount');
            $table->string('operation_from', 10);
            $table->string('operation_to', 10);
            $table->bigInteger('balance_from_before')->nullable();
            $table->bigInteger('balance_from_after')->nullable();
            $table->bigInteger('balance_to_before')->nullable();
            $table->bigInteger('balance_to_after')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_duplicate')->default(0);
            $table->boolean('is_negative')->default(0);
            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_debug_logs');
    }
};
