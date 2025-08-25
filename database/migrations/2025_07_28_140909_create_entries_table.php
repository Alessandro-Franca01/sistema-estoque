<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->enum('entry_type', ['purchased', 'feeding', 'reversal'])->default('purchased');
            $table->dateTime('entry_date');
            $table->text('observation')->nullable();
            $table->string('invoice_number', 30)->nullable();
            $table->string('contract_number', 20)->nullable();
            $table->string('batch_number', 10)->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('cascade'); // TODO: Reset database again
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entries');
    }
};
