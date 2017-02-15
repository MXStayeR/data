<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSellingStatDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_stat_day', function (Blueprint $table) {
            $table->integer('day');
            $table->integer('client_id');
            $table->integer('dmp_id');
            $table->integer('tax_id');
            $table->integer('hit');
            $table->primary(['day', 'client_id', 'dmp_id', 'tax_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_stat_day');
    }
}
