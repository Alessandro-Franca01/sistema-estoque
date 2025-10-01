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
            $table->enum('type', ['call_center', 'conectar_cabedelo', 'directive_solicitation', '1doc', 'other'])->default('call_center');
            $table->string('service_order', '30')->nullable();
            $table->string('connect_code', '20')->nullable();
            $table->string('phone', '15')->nullable();
            $table->string('applicant')->nullable();
            $table->string('memorandum_1doc', '15')->nullable();
            $table->text('destination');
            $table->string('cep', 8)->nullable();
            $table->string('complement')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['in_progress', 'finished', 'canceled'])->default('in_progress');
            $table->foreignId('output_id')->nullable()->constrained()->onDelete('cascade');
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
