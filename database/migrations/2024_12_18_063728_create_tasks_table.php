<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id'); // Foreign key must be unsignedBigInteger
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade'); // Reference the staff table
            $table->date('transaction_date');
            $table->text('description');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
