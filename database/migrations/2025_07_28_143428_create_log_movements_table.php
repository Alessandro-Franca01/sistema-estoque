<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->enum('action', ['entry', 'output', 'inventory', 'adjustment']);
            $table->decimal('amount', 10, 3);
            $table->dateTime('movement_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('user_id')->constrained('users');
            $table->text('destination')->nullable();
            $table->integer('reference_id')->nullable()->comment('ID da operação relacionada com o status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_movimentacoes');
    }
};
