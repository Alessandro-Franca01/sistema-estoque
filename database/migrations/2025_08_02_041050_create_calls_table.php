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
            $table->string('service_order')->nullable();
            $table->string('connect_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('caller_name')->nullable();
            $table->text('observation')->nullable();
            $table->foreignId('output_id')->nullable()->constrained()->onDelete('set null');
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
