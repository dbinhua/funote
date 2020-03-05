<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('cate_id')->default(0)->comment('分类ID');
            $table->string('slug', 100)->unique();
            $table->string('title', 200);
            $table->string('subtitle', 200)->default('')->comment('副标');
            $table->string('cover', 255)->nullable()->comment('封面');
            $table->string('intro', 255)->nullable()->comment('简介');
            $table->boolean('top')->default(false)->comment('是否置顶');
            $table->mediumText('content')->comment('markdown');
            $table->mediumText('html')->comment('html');
            $table->integer('view_count')->default(0)->comment('阅读数');
            $table->integer('praise_count')->default(0)->comment('点赞数');
            $table->integer('favorite_count')->default(0)->comment('收藏数');
            $table->enum('attr',[1,2])->default(1)->comment('属性：1-原创，2-转载');
            $table->integer('user_id');
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
