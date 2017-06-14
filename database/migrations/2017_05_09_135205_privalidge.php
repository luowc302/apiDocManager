<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Privalidge extends Migration
{
    public function up() {
        //
        if (!Schema::hasTable('Privalidges')) {
            Schema::create('Privalidges', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('uid'); //用户id
                $table->integer('project_id'); //项目id
                $table->integer('privalidge'); //权限
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/5/9
     */
    public static function install() {
        if (!Schema::hasTable('Privalidges')) {
            Schema::create('Privalidges', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('uid'); //用户id
                $table->integer('project_id'); //项目id
                $table->integer('privalidge'); //权限
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Privalidges');
    }
}
