<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

    public function index() {
        return view('admin.index');
    }

    /**
     * 显示系统所有成员
     */
    public function memberList() {
        return view('admin.paner');
    }
    
    /**
     * 项目列表
     * @return type
     */
    public function projectList(){
        return view('admin.project_list');
    }
    
    /**
     * 密码修改
     * @return type
     */
    public function pswEdit(){
        return view('admin.password');
    }
    
    /**
     * 系统设置
     * @return type
     */
    public function sysSetting(){
        return view('admin.system');
    }
    
    /**
     * 模板列表
     * @return type
     */
    public function template(){
        return view('admin.template');
    }
    
    /**
     * 模板添加
     * @return type
     */
    public function tplAdd(){
        return view('admin.tpl-add');
    }
    
    /**
     * 模板编辑
     * @return type
     */
    public function tplEdit(){
        $id = Input::get('id');
        $tplInfo = self::$template->where(['id' => $id])->get()->toArray();
        return view('admin.tpl-edit',['tplInfo' => $tplInfo]);
    }
    
    /**
     * 邮箱设置
     * @return type
     */
    public function emailConfig(){
        return view('admin.email_config');
    }
}
