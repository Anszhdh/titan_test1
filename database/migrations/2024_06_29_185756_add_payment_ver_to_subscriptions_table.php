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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->decimal('base_price', 8, 2)->after('price'); // Adjust the position as needed
            $table->decimal('shipping_price', 8, 2)->after('base_price');
            $table->decimal('total_price', 8, 2)->after('shipping_price');
            $table->boolean('payment_ver')->default(false)->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('payment_ver');
        });
    }
};
