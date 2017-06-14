<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Setting extends Migration
{
    public function up() {
        //
        if (!Schema::hasTable('Settings')) {
            Schema::create('Settings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50)->unique(); //配置名
                $table->integer('is_used'); //使用与否 1为使用 0为关闭
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/5/9
     */
    public static function install() {
        if (!Schema::hasTable('Settings')) {
            Schema::create('Settings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50)->unique(); //配置名
                $table->integer('is_used'); //使用与否 1为使用 0为关闭
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
        Schema::drop('Settings');
    }
}
