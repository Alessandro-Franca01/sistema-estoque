<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_output', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('output_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('quantity_used');
            $table->integer('quantity_returned');
            $table->boolean('is_finished')->default(false);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_output');
    }
};
