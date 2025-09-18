<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purposes', function (Blueprint $table) {
            $table->string('purpose_code', 32)->primary();
            $table->string('purpose_name', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purposes');
    }
};