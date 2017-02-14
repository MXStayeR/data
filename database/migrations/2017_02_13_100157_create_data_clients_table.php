<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128)->default("");
            $table->string('token', 64)->unique();
            $table->smallInteger('status')->default(0);
            $table->string('contact_name', 256)->default("");
            $table->string('contact_email', 256)->default("");
            $table->string('contact_phone', 256)->default("");
            $table->enum('security_type', ['ip', 'referrer', 'user_agent'])->default("ip");
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
        Schema::dropIfExists('data_clients');
    }
}
