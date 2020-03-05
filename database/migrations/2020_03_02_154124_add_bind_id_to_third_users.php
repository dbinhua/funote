<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBindIdToThirdUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('third_users', function (Blueprint $table) {
            $table->bigInteger('bind_id')->comment('绑定的账号')->nullable();
            $table->dropUnique('third_users_uid_type_unique');
            $table->unique(['bind_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('third_users', function (Blueprint $table) {
            $table->dropColumn('bind_id');
            $table->unique(['uid', 'type']);
            $table->dropUnique('third_users_bind_id_type_unique');
        });
    }
}
