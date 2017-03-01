<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRequestStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_request_stat_day', function (Blueprint $table) {
            $table->dropColumn('empty_response_count');
            $table->integer('unique_response_count');
            $table->integer('filled_response_count');
            $table->integer('unique_filled_response_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('data_request_stat_day', function (Blueprint $table) {
            $table->integer('empty_response_count');
            $table->dropColumn('unique_response_count');
            $table->dropColumn('filled_response_count');
            $table->dropColumn('unique_filled_response_count');
        });
    }
}
