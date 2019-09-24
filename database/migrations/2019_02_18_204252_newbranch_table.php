<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewbranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branchcode')->unique();
            $table->string('branchname');
            $table->unsignedInteger('regioncode');
            $table->timestamps();
            $table->foreign('regioncode')->references('id')->on('regions');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
