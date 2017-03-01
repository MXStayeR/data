<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('data_clients', function (Blueprint $table) {
            $table->integer('limit_request')->default(0);
            $table->integer('limit_unique_request')->default(0);
            $table->integer('limit_response')->default(0)->comment('not empty responses');
            $table->integer('limit_unique_response')->default(0)->comment('not empty unique responses');
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
        Schema::table('data_clients', function (Blueprint $table) {
            $table->dropColumn('limit_request');
            $table->dropColumn('limit_unique_request');
            $table->dropColumn('limit_response');
            $table->dropColumn('limit_unique_response');
        });
    }
}
