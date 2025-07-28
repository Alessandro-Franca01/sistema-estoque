<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
            $table->id();
            $table->string('connect_code')->nullable();
            $table->dateTime('output_date');
            $table->enum('call_type', ['whatssap', 'conectar_cabedelo', 'personally', 'phone', 'other'])->default('conectar_cabedelo');
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->string('whatsapp_number')->nullable();
            $table->string('caller_name')->nullable();
            $table->text('observation')->nullable();
            $table->text('destination')->nullable();
            $table->foreignId('public_servant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outputs');
    }
};
