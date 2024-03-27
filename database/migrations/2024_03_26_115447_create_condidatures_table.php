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
        Schema::create('condidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('benevole_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('annonce_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condidatures');
    }
};