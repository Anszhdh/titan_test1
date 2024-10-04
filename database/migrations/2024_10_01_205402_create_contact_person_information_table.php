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
        Schema::create('contact_person_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id')->index(); // Foreign key to business_information
            $table->string('name');
            $table->string('position');
            $table->string('email');
            $table->string('tel_no');
            $table->string('mobile_phone');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_person_information');
    }
};
