<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration {
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('user_name', 50)->unique(); //用户名
                $table->string('password', 255); //密码
                $table->string('email', 50); //邮箱
                $table->integer('is_used'); //是否停用 0  可用 1停用
                $table->timestamps();//创建时间更新时间
                $table->rememberToken();
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/4/21
     */
    public static function install(){
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('user_name', 50)->unique(); //用户名
                $table->string('password', 255); //密码
                $table->string('email', 50); //邮箱
                $table->integer('is_used'); //是否停用 //是否停用 0  可用 1停用
                $table->timestamps();//创建时间更新时间
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
        Schema::drop('users');
    }

}
