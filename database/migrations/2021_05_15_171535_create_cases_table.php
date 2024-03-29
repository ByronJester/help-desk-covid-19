<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virus_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('place_id')->unsigned()->comment('Foreign key from table places');
            $table->string('code')->unique();
            $table->integer('age');
            $table->string('symptom');
            $table->string('gender')->comment("MALE, FEMALE");
            $table->date('date');
            $table->string('travel_history')->nullable();
            $table->string('status')->nullable()->comment('RECOVERED, DEATH', 'QUARANTINE');
            $table->date('recovered_at')->nullable();
            $table->date('death_at')->nullable();
            $table->date('quarantine_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreign('place_id')->references('id')->on('places');

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
        Schema::dropIfExists('virus_cases');
    }
}
