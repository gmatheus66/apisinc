<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('password');
            $table->date('birthday');
            $table->enum('sexo',['Male','Female','Another']);
            $table->integer('telephone');
            $table->string('email');
            $table->string('ocupation');
            $table->string('token_watchband');
            $table->string('token_login');
            $table->string('address');
            $table->string('city');
            $table->string('contry');
            $table->string('state_province');
            $table->rememberToken();
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
        Schema::dropIfExists('patients');
    }
}
