<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainings4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training4s', function (Blueprint $table) {
            $table->id();
            $table->string('trainer_id')->nullable();
            $table->string('employees_id')->nullable();
            $table->string('start_date')->nullable();
            $table->string('trainer')->nullable();
            $table->string('students')->nullable();
            $table->text('training_type')->nullable();
            $table->json('today_tasks')->nullable(); // Update the column type to JSON
            $table->text('conclusion')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training4s');
    }
}
