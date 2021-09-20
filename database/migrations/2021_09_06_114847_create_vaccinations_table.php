<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('place_id')->unsigned()->comment('Foreign key from table places');
            $table->bigInteger('vaccine_id')->unsigned()->comment('Foreign key from table places');
            $table->string('name');
            $table->integer('age');
            $table->date('birth_date');
            $table->string('phone');
            $table->string('gender')->comment("MALE, FEMALE");
            $table->string('classification');
            $table->string('status')->default('pending')->comment("pending, ongoing, finish");

            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
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
        Schema::dropIfExists('vaccinations');
    }
}
