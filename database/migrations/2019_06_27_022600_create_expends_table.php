<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expends', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('type');
            $table->bigInteger('money_after');
            $table->bigInteger('money_before');
            $table->integer('wallet_id')->unsigned();
            $table->bigInteger('value')->unsigned();
            $table->timestamps();
        });
        Schema::table('expends', function($table) {
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expends');
    }
}
