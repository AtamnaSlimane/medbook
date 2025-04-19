<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            // Both references to the 'users' table
            $table->foreignId('patient_id')->constrained('users');
            $table->foreignId('doctor_id')->constrained('users');
            $table->dateTime('appointment_date');
            $table->unsignedInteger('duration')->default(30);
            $table->enum('status', ['pending','booked', 'completed', 'canceled','rejected'])->default('booked');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('appointment_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

