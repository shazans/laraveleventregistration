<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TajneedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tajneed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('AIMS')->unique();
            $table->string('branchcode');
            $table->string('Name');
            $table->string('Status');
            $table->string('Mobile');

            $table->foreign('branchcode')->references('branchcode')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tajneed');
    }
}
