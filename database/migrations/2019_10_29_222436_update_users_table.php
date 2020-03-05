<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->comment('头像');
            $table->bigInteger('third_auth_id')->comment('关联三方ID')->nullable()->unique();
            $table->string('email')->nullable()->change();
            $table->tinyInteger('status')->default(1)->comment('状态（1-正常，2-冻结，0-未激活）');
            $table->tinyInteger('gender')->default(0)->comment('性别（1-男，2-女，0-未知）');
            $table->unsignedTinyInteger('rank')->default(1)->comment('级别（1-注册用户，8-超级管理员）');
            $table->unsignedSmallInteger('profession')->nullable()->comment('职业');
            $table->string('constellation')->nullable()->comment('星座');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('third_auth_id');
            $table->string('email')->change();
            $table->dropColumn('status');
            $table->dropColumn('gender');
            $table->dropColumn('rank');
            $table->dropColumn('profession');
            $table->dropColumn('constellation');
        });
    }
}
