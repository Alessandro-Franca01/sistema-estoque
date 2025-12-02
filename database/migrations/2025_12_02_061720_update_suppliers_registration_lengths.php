<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Increase lengths: state_registration -> 11, municipal_registration -> 9
            $table->string('state_registration', 11)->nullable()->change();
            $table->string('municipal_registration', 9)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Revert to previous lengths: state_registration -> 9, municipal_registration -> 7
            $table->string('state_registration', 9)->nullable()->change();
            $table->string('municipal_registration', 7)->nullable()->change();
        });
    }
};
