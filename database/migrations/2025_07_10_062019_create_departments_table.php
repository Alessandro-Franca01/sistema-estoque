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
        // TODO: Create new role to User "MAINTENANCE", this role will have permission to create, read, update, delete Departments
        // This user will be able to send email with link to create first user
        // This not be access to system features normmals, only to create first user and departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sigla');
            $table->text('description')->nullable();
            $table->string('cep', 8)->nullable();
            $table->text('address')->nullable();
            $table->string('number', 4)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
