<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Folder extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasTable('folders')) {
            Schema::create('folders', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->index('id_sort');
                $table->string('folder_name', 50); //目录名
                $table->integer('add_time'); //创建时间
                $table->integer('pid')->index('pid_sort'); //父id 0 为无跟随 其他为跟随其他目录（可能不需要）
                $table->integer('project_id')->index('project_sort'); //项目id
                $table->integer('sort')->default(255)->index('sort'); //排序字段
                $table->softDeletes();//软删除
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/4/21
     */
    public static function install(){
        if (!Schema::hasTable('folders')) {
            Schema::create('folders', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->index('id_sort');
                $table->string('folder_name', 50); //目录名
                $table->integer('add_time'); //创建时间
                $table->integer('pid')->index('pid_sort'); //父id 0 为无跟随 其他为跟随其他目录（可能不需要）
                $table->integer('project_id')->index('project_sort'); //项目id
                $table->integer('sort')->default(255)->index('sort'); //排序字段
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
        Schema::drop('folders');
    }

}
