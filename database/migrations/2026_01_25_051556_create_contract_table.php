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
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->nullable();
            $table->string('contract_number', 20)->nullable();
            $table->dateTime('contract_date');
            $table->decimal('value', 10, 2)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};
