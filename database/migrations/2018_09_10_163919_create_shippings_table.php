<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('departure_port_id');
            $table->unsignedInteger('arrival_port_id');
            $table->unsignedInteger('status');
            $table->float('cost');
            $table->text('remarks')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('departure_port_id')->references('id')->on('ports');
            $table->foreign('arrival_port_id')->references('id')->on('ports');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('shippings');
    }
}
