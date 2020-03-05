<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThirdUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid');
            $table->string('nickname')->comment('昵称');
            $table->tinyInteger('gender')->comment('性别（1-男，2-女，0-未知）');
            $table->tinyInteger('type')->comment('类型（1-微博）');
            $table->string('avatar');
            $table->string('avatar_large');
            $table->string('access_token');
            $table->timestamps();
            $table->unique(['uid', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('third_users');
    }
}
