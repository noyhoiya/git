<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->foreignId('requester_vault_id')->constrained('vaults', 'vault_id');
            $table->foreignId('requester_user_id')->constrained('users', 'user_id');
            $table->bigInteger('amount_cents');
            $table->string('amount_in_words', 255);
            $table->string('purpose_code', 32)->nullable();
            $table->string('purpose_text', 255)->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'CANCELLED'])
                  ->default('PENDING');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approver_user_id')->nullable()
                  ->constrained('users', 'user_id');
            $table->string('notes', 255)->nullable();
            $table->timestamps();

            $table->foreign('purpose_code')->references('purpose_code')->on('purposes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_requests');
    }
};