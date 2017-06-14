<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Page extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->index('id_sort');
                $table->integer('fid')->index('fid_sort'); //跟随的目录id 0 为根目录 其他是子目录
                $table->integer('project_id'); //项目id 当fid为0时需要填，不为0时可以不用
                $table->string('title', 50); //文章标题
                $table->text('content'); //文章内容
                $table->integer('sort')->default(255)->index('sort'); //排序字段
                $table->integer('add_time'); //创建时间
                $table->softDeletes();//软删除
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/4/21
     */
    public static function install(){
        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('fid')->index('id_sort'); //跟随的目录id 0 为根目录 其他是子目录
                $table->integer('project_id')->index('fid_sort'); //项目id 当fid为0时需要填，不为0时可以不用
                $table->string('title', 50); //文章标题
                $table->text('content'); //文章内容
                $table->integer('sort')->default(255)->index('sort'); //排序字段
                $table->integer('add_time'); //创建时间
                $table->softDeletes();//软删除
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('pages');
    }

}
