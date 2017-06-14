<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Page;
use App\Folder;
use App\Privalidge;
use App\Template;
//use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController {

//    use AuthorizesRequests, DispatchesJobs,ValidatesRequests;

    public $role = []; //权限管理，需要权限才能访问的方法
    public $uid; //用户id
    public $projectId;
    public $inputName = [];//与projectId有关联的输入,保持与数据库对应字段一致
    public static $validator;
    public static $rule = [];
    public static $message = [];
    public static $jsonList;
    public static $project; //项目模型
    public static $user; //用户模型
    public static $folder;//文件夹模型
    public static $page;//文章模型
    public static $private;//权限模型
    public static $template;//模板模型

    public function __construct() {
        if (checkLock()) {//如果文件存在则无操作
            self::$project = new Project; //初始化需要的模型
            self::$user = new User;
            self::$folder = new Folder;
            self::$page = new Page;
            self::$private = new Privalidge;
            self::$template = new Template;
            empty(Session::get('uid')) ? $this->uid = Cookie::get('user_info')['uid'] : $this->uid = Session::get('uid');
            $this->checkRole();
        } else {//跳转至安装页面
            Redirect::to('/install')->send();
        }
    }

    /**
     * 获取projectId
     * @return mix
     */
    private function _setProjectId(){
        $projectId = Input::get('project_id');
        if(!empty($projectId)){
            return $projectId;
        }
        else{
            foreach ($this->inputName as $key => $value){
                $projectId = $this->getProjectId($value, 'projects', self::$$key);
                if($projectId){
                    return  $projectId;
                }
            }
        }
        return FALSE;
    }
    
    /**
     * 根据是否有字段查询数据
     * @param type $value
     * @param type $tables
     * @param type $model
     * @return mix
     */
    public function getProjectId($value, $tables, $model) {
        $columns = Schema::getColumnListing($tables);
        if (in_array($value, $columns)) {
            $map = Input::get($value);
            $info = $model->where([$value => $map])->first();
            if (!empty($info)) {
                return $info['project_id'];
            }
        }
        return FALSE;
    }

    /**
     * 检查角色
     * @author luowencai 2017/5/8
     */
    private function checkRole() {
        if (in_array(getCurrentMethodName(), $this->role)) {
            $this->projectId = $this->_setProjectId();
            if ($this->projectId) {
                if ($this->checkPrivalidage() == 0) {
                    if (Request::ajax()) {
                        header('Content-type: text/json');
                        $error = json_encode(['msg' => "你不具备相应的权限", 'code' => 0]);
                        exit($error);
                    } else {
                        Redirect::to('/roles')->send();
                    }
                }
            }
        }
    }

    /**
     * 设置json格式数据
     * @param type $msg 提示信息
     * @param type $code 提示码
     * @param type $data 数据
     * @return type
     */
    public function jsonReturn($msg = '', $code = 0, $data = null) {
        return response()->json(['msg' => $msg, 'code' => $code, 'data' => $data]);
    }

    /**
     * 设置规则
     * @author luowencai 2017/4/22
     * @param type $rule
     */
    public static function _setRule($rule) {
        self::$rule = $rule;
    }

    /**
     * 设置错误提示
     * @author luowencai 2017/4/22
     * @param type $message
     */
    public static function _setMessage($message) {
        self::$message = $message;
    }

    /**
     * 表单检验
     * @author luowencai 2017/4/15
     * @param array $data
     * @return type
     */
    public static function validator(array $data) {
        self::$validator = Validator::make($data, self::$rule, self::$message);
    }

    /**
     * 获取表单验证失败的第一条信息
     * @author luowencai 2017/4/22
     *  @return staring
     */
    public static function message() {
        return self::$validator->messages()->first();
    }

    /**
     * 获取所有错误信息
     * @author luowencai 2017/4/22
     * @return array
     */
    public static function allMessage() {
        return self::$validator->messages()->all();
    }

    /**
     * 通过传入操作名，注意操作名对应验证规则
     * @param type $operate
     * @param type $data
     */
    public static function _setOperateRule($operate, $data) {
        $function = '_set' . $operate . 'Rule';
        static::$function();
        self::_setRule(self::$rule); //初始化规则
        self::validator($data); //开始验证
    }

    /**
     * 判断项目下具备的操作权限
     * 处理逻辑-直接查找权限表，获取权限
     * @author luowencai 2017/5/5
     * @param type $uid 用户id
     * @param type $project_id 项目id
     * @param type $userModel 用户模型
     * @param type $projectModel 项目模型
     * @return int 0 可读 1读写 2 没有加入项目
     */
    public function checkPrivalidage() {
        $privateInfo = self::$private->where(['uid' => $this->uid, 'project_id' => $this->projectId])->get()->toArray();
        if(empty($privateInfo)){//没有查找到说明
            $projectInfo = self::$project->checkIfOwner($this->uid, $this->projectId);
            if(empty($projectInfo)){
                return 2;
            }
            else{
                return 1;
            }
        }
        else{
            return $privateInfo[0]['privalidge'];
        }
    }

}
