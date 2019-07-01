<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('code');
            $table->string('email')->unique();
            $table->date('birthday')->nullable();
            // $table->integer('wallet_id')->default(0);
            $table->string('images')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // $table->boolean('confirmed')->default(0);
            // $table->string('confirmation_code')->nullable();
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
        Schema::dropIfExists('users');
    }
}
