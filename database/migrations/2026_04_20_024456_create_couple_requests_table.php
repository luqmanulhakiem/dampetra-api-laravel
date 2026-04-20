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
        Schema::create('couple_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requested_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('invited_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->enum('is_approved', ['requested', 'declined', 'approved'])->default('requested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couple_requests');
    }
};
