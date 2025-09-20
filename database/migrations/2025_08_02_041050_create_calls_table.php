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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['whatssap', 'conectar_cabedelo', 'personally', 'phone', 'other'])->default('conectar_cabedelo');
            $table->string('service_order', '30')->nullable();
            $table->string('connect_code', '20')->nullable();
            $table->string('phone')->nullable();
            $table->string('applicant')->nullable();
            $table->text('destination');
            $table->string('cep', 8)->nullable();
            $table->string('complement')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['in_progress', 'finished', 'cancelled'])->default('in_progress');
            $table->foreignId('output_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
