<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Admin extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasTable('admins')) {
            //
            Schema::create('admins', function (Blueprint $table) {
                $table->increments('id');
                $table->string('user_name', 50)->unique(); //用户名
                $table->string('password', 255); //密码
                $table->rememberToken();
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/4/21
     */
    public static function install() {
        if (!Schema::hasTable('admins')) {
            //
            Schema::create('admins', function (Blueprint $table) {
                $table->increments('id');
                $table->string('user_name', 50)->unique(); //用户名
                $table->string('password', 255); //密码
                $table->rememberToken();
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
        Schema::drop('admins');
    }

}
