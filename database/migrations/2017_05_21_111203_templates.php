<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Templates extends Migration
{
   
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasTable('templates')) {
            Schema::create('templates', function (Blueprint $table) {
                $table->increments('id')->index('id_sort');
                $table->string('title', 50); //文章标题
                $table->text('content'); //文章内容
                $table->integer('add_time'); //创建时间
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/4/21
     */
    public static function install(){
        if (!Schema::hasTable('templates')) {
            Schema::create('templates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 50); //文章标题
                $table->text('content'); //文章内容
                $table->integer('add_time'); //创建时间
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
        Schema::drop('templates');
    }

}
