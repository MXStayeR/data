<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataRequestStatDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_request_stat_day', function (Blueprint $table) {
            $table->integer('day');
            $table->integer('client_id');
            $table->integer('request_count');
            $table->integer('request_unique_count');
            $table->integer('error_request_count');
            $table->integer('response_count');
            $table->integer('empty_response_count');
            $table->integer('error_response_count');
            $table->primary(['day', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_request_stat_day');
    }
}
