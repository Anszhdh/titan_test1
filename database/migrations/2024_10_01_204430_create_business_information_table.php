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
        Schema::create('business_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Foreign key to users
            $table->string('business_name');
            $table->string('business_registration_no');
            $table->string('name_of_owner');
            $table->text('address');
            $table->text('delivery_address')->nullable();
            $table->string('tel_no');
            $table->string('social_media')->nullable(); // JSON or comma-separated
            $table->string('website')->nullable();
            $table->string('email');
            $table->year('year_started');
            $table->enum('business_structure', ['Wholesaler', 'Retailer', 'Installation Workplace', 'Mail Order', 'Internet Sales', 'Other']);
            $table->string('number_of_employees');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_information');
    }
};
