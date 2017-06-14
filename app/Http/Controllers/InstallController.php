<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Admin;
use App\Setting;
use App\Template;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect;

class InstallController extends BaseController {//继承base控制器

    /**
     * 安装页面
     * @author luowencai 2017/4/13
     * @return redirect or view
     */
    public function install() {
        if (checkLock()) {//如果文件存在则跳转至首页
            return Redirect::to('/');
        } else {
            return view('home/config');
        }
    }
    
    /**
     * 初始化配置
     */
    public function setEnv(){
        if (!checkLock()) {
            $config['DB_HOST'] = Input::get('DB_HOST');
            $config['DB_DATABASE'] = Input::get('DB_DATABASE');
            $config['DB_USERNAME'] = Input::get('DB_USERNAME');
            $config['DB_PASSWORD'] = Input::get('DB_PASSWORD');
            if(!updateEnv($config)){
                echo '缺少配置文件！';
                exit(0);
            }
            return view('home/install');
        }
    }

    /**
     * 安装操作
     * @author luowencai 2017/4/13
     */
    public function doInstall() {
        if (!checkLock()) {
            $param['user_name'] = Input::get('user_name');
            $param['password'] = Input::get('password');
            $this->createTable();
            Admin::createAdmin($param);
            Setting::insertConfig(config('options.function'));
            Template::insertConfig(config('options.template'));
            $fopen = fopen(config('options.lockFiles'), 'wb '); //新建文件命令 
            fputs($fopen, ''); //向文件中写入内容; 
            fclose($fopen);
            return view('home/install_success');
        } else {//如果文件存在则报错
            echo '错误，已经安装初始化过';
        }
    }

    /**
     * 创建系统需要的数据表
     * @author luowencai 2017/4/13
     * @return void
     */
    public function createTable() {
        \Admin::install();
        \Folder::install();
        \Page::install();
        \Project::install();
        \User::install();
        \Setting::install();
        \Privalidge::install();
        \Templates::install();
        return TRUE;
    }

}
