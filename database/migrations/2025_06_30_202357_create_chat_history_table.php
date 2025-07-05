<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->text('response');
            $table->string('session_id')->nullable(); // Para agrupar conversaciones
            $table->json('metadata')->nullable(); // Metadatos adicionales
            
            $table->timestamps();
        });

        // Índice para búsquedas eficientes
        Schema::table('chat_history', function (Blueprint $table) {
            $table->index(['user_id', 'created_at']);
            $table->fullText(['message', 'response']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_history');
    }
};