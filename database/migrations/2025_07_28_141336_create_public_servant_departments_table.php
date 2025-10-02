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
        Schema::create('public_servant_departments', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->enum('job_function', ['ADMINISTRADOR', 'ALMOXARIFE', 'OPERADOR', 'SERVIDOR'])->default('SERVIDOR');
            $table->foreignId('public_servant_id')->constrained('public_servants')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['public_servant_id', 'department_id'], 'ps_department_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_servant_departments');
    }
};
