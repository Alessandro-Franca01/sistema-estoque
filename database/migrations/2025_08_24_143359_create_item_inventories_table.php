<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('item_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('register_amount', 10, 3);
            $table->decimal('real_amount', 10, 3)->nullable();
            $table->decimal('difference', 10, 3)->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_inventarios');
    }
};
