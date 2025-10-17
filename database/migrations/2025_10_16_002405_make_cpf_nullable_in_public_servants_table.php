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
        // TODO: FAZER TESTES NA MIGRATIONS E VERIFICAR SE A TABELA PUBLIC_SERVANTS ESTÁ SENDO ALTERADA CORRETAMENTE
        Schema::table('public_servants', function (Blueprint $table) {
            $table->dropUnique('public_servants_cpf_unique');
            $table->string('cpf', 11)->nullable()->change();
            $table->string('registration', 9)->unique()->change();
//            $table->unique('public_servants_registration_unique');
            $table->string('outsourced_company')->nullable();
            $table->enum('servant_type', ['EFETIVO', 'COMISSIONADO', 'TERCEIRIZADO'])->default('EFETIVO');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_servants', function (Blueprint $table) {
//            $table->string('cpf', 11)->nullable()->change(); // ESSE LINHA FICA DE FORA, FOI UMA GAMBI
            $table->string('cpf', 11)->nullable(false)->change();
            $table->unique('cpf');
            $table->dropColumn('outsourced_company');
            $table->enum('servant_type', ['EFETIVO', 'COMISSIONADO', 'TERCEIRIZADO'])->default('EFETIVO')->change();
            $table->string('registration', 9)->nullable()->change();
            $table->dropUnique('public_servants_registration_unique');
        });
    }
};
