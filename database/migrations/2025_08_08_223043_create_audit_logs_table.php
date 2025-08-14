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
        // Laravel 11 Inventory System Migrations <- DEEPSEEK CHAT NAME
        Schema::create('audit_logs', function (Blueprint $table) {
            // Identificação básica
            $table->id();

            // Informações sobre o evento
            $table->string('event'); // Tipo de ação: created, updated, deleted, viewed, exported, etc.
            $table->string('auditable_type'); // Classe do modelo afetado (ex: App\Models\Product)
            $table->unsignedBigInteger('auditable_id'); // ID do registro afetado

            // Dados de alteração
            $table->json('old_values')->nullable(); // Valores antes da alteração (em formato JSON)
            $table->json('new_values')->nullable(); // Valores após a alteração (em formato JSON)

            // Contexto da requisição
            $table->string('url')->nullable(); // URL onde ocorreu a ação
            $table->string('ip_address', 45); // Endereço IP (suporta IPv6)
            $table->string('user_agent')->nullable(); // Informações do navegador/cliente

            // Metadados e organização
            $table->string('tags')->nullable(); // Tags para categorização/filtro
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('SET NULL'); // Usuário responsável pela ação

            // Timestamps
            $table->timestamps();

            // Índices para otimização de consultas
            $table->index(['auditable_type', 'auditable_id']); // Busca por registro específico
            $table->index(['user_id', 'created_at']); // Busca por ações de um usuário
            $table->index(['event', 'created_at']); // Busca por tipo de evento
            $table->index('auditable_type'); // Busca geral por tipo de modelo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
