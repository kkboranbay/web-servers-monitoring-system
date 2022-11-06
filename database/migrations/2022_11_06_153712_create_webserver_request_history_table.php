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
        Schema::create('webserver_request_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webserver_id');
            $table->tinyInteger('status');
            $table->timestamp('response_at');
            $table->timestamps();

            $table->foreign('webserver_id')->references('id')->on('webservers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webserver_request_history');
    }
};
