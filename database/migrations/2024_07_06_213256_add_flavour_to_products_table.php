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
        Schema::table('products', function (Blueprint $table) {
            $table->string('flavor')->nullable();
            $table->string('roast_level')->nullable();
            $table->string('brewing_method')->nullable();
            $table->boolean('pre_ground')->nullable();
            $table->boolean('decaf')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['flavor', 'roast_level', 'brewing_method', 'pre_ground', 'decaf']);
        });
    }
};
