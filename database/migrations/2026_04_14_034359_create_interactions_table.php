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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->text('description')->nullable();
            $table->enum('intensity_score', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->default(8);
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
