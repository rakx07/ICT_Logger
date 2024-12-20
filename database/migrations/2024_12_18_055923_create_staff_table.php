<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id(); // This creates an unsignedBigInteger primary key
            $table->string('first_name'); // Separate first name field
            $table->string('middle_name')->nullable(); // Optional middle name field
            $table->string('last_name'); // Separate last name field
            $table->string('email')->unique(); // Add unique constraint to email
            $table->string('position');
            $table->string('phone_number')->nullable(); // Optional phone number field
            $table->text('address')->nullable(); // Optional address field

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
}
