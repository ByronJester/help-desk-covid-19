<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTracingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_tracings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('place_id')->unsigned()->comment('Foreign key from table places');
            $table->bigInteger('virus_case_id')->unsigned()->comment('Foreign key from table virus_cases');
            $table->string('name');
            $table->integer('age');
            $table->date('birth_date');
            $table->string('phone');
            $table->string('gender')->comment("MALE, FEMALE");
            $table->string('status')->default('active')->comment("active or inactive");

            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('virus_case_id')->references('id')->on('virus_cases');
            $table->softDeletes();
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
        Schema::dropIfExists('contact_tracings');
    }
}
