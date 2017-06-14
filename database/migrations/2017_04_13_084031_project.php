<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Project extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->index('projec_id_sort');
                $table->integer('uid'); //项目所属的用户id
                $table->string('project_name', 50); //项目名称
                $table->integer('add_time'); //创建时间
            });
        }
    }
    
    /**
     * web安装操作
     * @author luowencai 2017/4/21
     */
    public static function install(){
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->index('projec_id_sort');
                $table->integer('uid'); //项目所属的用户id
                $table->string('project_name', 50); //项目名称
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
        Schema::drop('projects');
    }

}
