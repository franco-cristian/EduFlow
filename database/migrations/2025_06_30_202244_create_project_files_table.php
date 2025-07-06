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
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('stored_name')->unique(); // Nombre único para el archivo almacenado
            $table->string('mime_type');
            $table->unsignedBigInteger('size'); // Usar unsignedBigInteger para tamaños de archivo
            $table->string('path')->nullable(); // Ruta de almacenamiento (opcional si usas Storage)
            $table->text('description')->nullable(); // Descripción opcional

            // Relaciones
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            
            // CORRECCIÓN AQUÍ:
            // La columna 'uploaded_by' debe ser nullable para que onDelete('set null') funcione.
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes(); // Eliminación suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_files');
    }
};