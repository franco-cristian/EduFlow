<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('stored_name')->unique(); // Nombre único para el archivo almacenado
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->string('path'); // Ruta de almacenamiento
            $table->text('description')->nullable(); // Descripción opcional
            
            // Relaciones
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes(); // Eliminación suave
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_files');
    }
};