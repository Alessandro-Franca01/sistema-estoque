<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('measurement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acronym', 20);
            $table->text('description')->nullable();
            $table->decimal('used_measurement', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('measurement_types');
    }
};
