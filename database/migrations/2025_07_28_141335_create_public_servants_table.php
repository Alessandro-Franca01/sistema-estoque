<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('public_servants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registration');
            $table->string('cpf', 11);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('role', ['OPERADOR', 'ALMOXARIFE', 'SERVIDOR'])->default('SERVIDOR');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('public_servants');
    }
};
