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
        Schema::table('order_items', function (Blueprint $table) {
            // Drop any existing foreign key constraint (if necessary)
            $table->dropForeign(['order_id']);

            // Add the foreign key constraint with explicit name
            $table->foreign('order_id', 'fk_order_items_orders')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['order_id']);
        });
    }
};
