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
            $table->string('cpf', 11)->unique();
            $table->string('registration')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->enum('job_function', ['ADMINISTRADOR', 'ALMOXARIFE', 'OPERADOR', 'SERVIDOR'])->default('SERVIDOR');
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('public_servants');
    }
};
