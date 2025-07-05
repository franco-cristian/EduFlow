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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['planning', 'in_progress', 'completed'])->default('planning');
            $table->date('start_date');
            $table->date('end_date');
            
            // Creador del proyecto (estudiante)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Profesor asignado (puede ser nulo si aún no se asigna)
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};