<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cgpi_id')->unsigned(); 
            $table->string('name');
            $table->string('email')->unique();
            $table->bigInteger('num_tel');
            $table->string('raison_sociale');
            $table->string('location');
            $table->string('industry');
            $table->bigInteger('aum');
            $table->timestamps();

            $table->foreign('cgpi_id')
                ->references('id')
                ->on('cgpis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
