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
        Schema::create('booths', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // e.g., SP5, SP12
            $table->string('coords'); // e.g., "300,450,400,500"
            $table->enum('shape', ['rect', 'circle', 'poly'])->default('rect');
            $table->string('status')->default('available');
            $table->string('type')->nullable(); // optional: standard, premium, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booths');
    }
};
