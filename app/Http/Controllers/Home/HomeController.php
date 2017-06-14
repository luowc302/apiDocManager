<?php

/**
 * 主要负责前台显示操作
 * @author luowencai
 */

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller {

    //需要权限限制的方法
    public $role = [
        'pageDetail', 'pageAdd',
    ]; 
    //权限限制方法用于获取项目id的相关字段
    public $inputName = [
        'page' => 'id',
        'folder' => 'project_id',
    ]; 
    

    public function __construct() {
        parent::__construct();
    }

    /**
     * 首页
     * @author luowencai 2017/4/13
     * @return type
     */
    public function index() {
        return view('home/index');
    }

    /**
    * 重置管理员密码
    * @url /reset
    */
    public function resetAdmin(){
        if(file_exists(config('options.reset'))){
            \App\Admin::resetAdmin();
            echo '重置管理员密码成功，重置为：123456 请马上登陆修改密码';
        }
        else{
            abort(404);
        }
    }
    
    /**
     * 登陆页
     * @return type
     */
    public function login(){
        return view('home/login');
    }

    /**
     * 无访问权时
     * @author luowencai 2017/5/8
     * @return type
     */
    public function roles() {
        return view('errors/roles');
    }
    
    /**
     *功能关闭页面
     */
    public function shutdown(){
        return view('errors/shutdown');
    }

    /**
     * 输出验证码并保存至session
     */
    public function vrcode() {
        $vrcode = app()->make('VrCode');
        Session::put('validateCode', $vrcode->getcode());
        $vrcode->outimg();
    }

    /**
     * 注册页面
     * @author luowencai 2017/4/13
     */
    public function regist() {
        return view('home/regist');
    }

    /**
     * 前台展示页面
     * 主要负责显示项目列表
     * @author luowencai 2017/4/15
     */
    public function paner() {
        return view('home/paner');
    }

    /**
     * 项目编辑页面
     * @author luowencai 2017/4/15
     */
    public function editShow() {
        $projectId = Input::get('id');
        $projectInfo = self::$project->where(['id' => $projectId])->get();
        $identify = config('options.identify');
        return view('home/edit_project', [
            'project_id' => $projectId,
            'project_name' => $projectInfo[0]['project_name'],
            'identifys' => $identify,
        ]);
    }

    /**
     * 显示进入项目后的内容
     * @author luowencai 2017/4/15
     */
    public function pageShow() {   
        $this->projectId = Input::get('id');
        $projectName = self::$project->where(['id' => $this->projectId])->select('project_name')->get()->toArray();
        if(empty($projectName)){
            abort(404);
        }
        $privalidge = $this->checkPrivalidage();
        if($privalidge == 2){
            return redirect('/roles');
        }
        $showNavDiffcult = config('options.nav_option_show')['show_two'];
        return view('home/page_show', [
            'navShow' => $showNavDiffcult,
            'project_name' => $projectName[0]['project_name'],
            'project_id' => $this->projectId,
            'private' => $privalidge,
            'page_show' => 1,
        ]);
    }

    /**
     * 显示文章编辑详情
     * @author luowencai 2017/4/15
     */
    public function pageDetail() {
        $pageId = Input::get('id');
        $pageDetail = self::$page->where(['id' => $pageId])->get()->toArray();
        $folderInfo = self::$folder->where(['project_id' => $pageDetail[0]['project_id']])->get()->toArray();
        $resInfo = self::$folder->createFolderList($folderInfo);
        $templateInfo = self::$template->allList();
        $showNavDiffcult = config('options.nav_option_show')['hider_nav'];
        return view('home/page_detail', [
            'navShow' => $showNavDiffcult,
            'page_id' => $pageId,
            'project_id' => $pageDetail[0]['project_id'],
            'folderInfo' => $resInfo,
            'pageInfo' => $pageDetail[0],
            'templateInfo' => $templateInfo,
        ]);
    }

    /**
     * 显示文章添加页面
     * @author luowencai 2017/5/5
     */
    public function pageAdd() {
        $projectId = Input::get('project_id');
        $folderInfo = self::$folder->where(['project_id' => $projectId])->get()->toArray();
        $templateInfo = self::$template->allList();
        $resInfo = self::$folder->createFolderList($folderInfo);
        $showNavDiffcult = config('options.nav_option_show')['hider_nav'];
        return view('home/page_add', [
            'navShow' => $showNavDiffcult,
            'project_id' => $projectId,
            'folderInfo' => $resInfo,
            'templateInfo' => $templateInfo,
        ]);
    }

}
