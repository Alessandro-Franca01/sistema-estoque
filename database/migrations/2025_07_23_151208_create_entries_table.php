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
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->dateTime('entry_date');
            $table->text('observation')->nullable();
            $table->boolean('is_existing')->default(false);
            $table->string('invoice_number', 30)->nullable();
            $table->string('contract_number', 20)->nullable();
            $table->string('batch_number', 10)->nullable();
            $table->decimal('value', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entries');
    }
};
