<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('base_price', 10, 2)->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('base_price');
            $table->dropColumn('sku');
            $table->dropColumn('quantity');
        });
    }
}
