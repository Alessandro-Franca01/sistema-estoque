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
        Schema::table('item_inventories', function (Blueprint $table) {
            $table->enum('difference_type', ['LOSS', 'MISPLACED', 'BROKEN', 'NONE'])->default('NONE');
            $table->renameColumn('observations', 'reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_inventories', function (Blueprint $table) {
            $table->dropColumn('difference_type');
            $table->renameColumn('observations', 'reason');
        });
    }
};
