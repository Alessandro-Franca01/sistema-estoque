<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('output_date');
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->text('observation')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('public_servant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outputs');
    }
};
