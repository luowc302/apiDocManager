<?php

/**
 * 主要负责后台页面的一些显示操作
 * @author luowencai
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller {

    public static $admin; //管理员模型
    public static $message = [
        'user_name.required' => '用户名为空',
        'user_name.max' => '用户名超出',
        'password.required' => '密码为空',
        'password.min' => '密码小于6位',
        'newPassword.required' => '密码为空',
        'newPassword.confirmed' => '两次输入的密码不一致',
        'newPassword.min' => '密码小于6位',
    ]; //验证不通过的提示

    public function __construct() {
        parent::__construct();
        self::$admin = new Admin;
        self::_setMessage(self::$message); //初始化错误提示
    }

    /**
     * 登入时需要的规则
     */
    public static function _setLoginRule() {
        self::$rule = [
            'user_name' => 'required|max:255',
            'password' => 'required|min:6',
        ]; //表单验证规则
    }
    
     public static function _setUpdateRule() {
        self::$rule = [
            'password' => 'required|min:6',
            'newPassword' => 'required|confirmed|min:6',
        ]; //表单验证规则
    }
    
    /**
     * 更新管理员密码
     * @return type
     */
    public function updatePassword() {
        $password = Input::get('old_password');
        $newPassword = Input::get('new_password');
        $confirmPsw = Input::get('repeat_password');
        $data = [
            'password' => $password,
            'newPassword' => $newPassword,
            'newPassword_confirmation' => $confirmPsw,
        ];
        self::_setOperateRule('Update', $data);
        if (self::$validator->fails()) {
            return response()->json(['msg' => self::message(), 'code' => 0]);
        }
        $userInfo = self::$admin->where(['id' => Session::get('adminId')])->get()->toArray();
        if (empty($userInfo[0]['password'])) {
            return $this->jsonReturn('未知错误！', 0);
        }
        $hashPassword = $userInfo[0]['password'];
        if (password_verify((string) $password, (string) $hashPassword)) {
            if (self::$admin->where(['id' => Session::get('adminId')])->update(['password' => password_hash((string) $newPassword, PASSWORD_DEFAULT)])) {
                return $this->jsonReturn('修改成功！', 1);
            } else {
                return $this->jsonReturn('修改失败！', 0);
            }
        }
    }

    /**
     * 登入操作
     * @author luowencai 2017/4/13
     */
    public function doLogin() {
        $userName = Input::get('user_name');
        $password = Input::get('password');
        $vrCode = Input::get('vrCode');
        if(!codeValidate($vrCode)){
            return $this->jsonReturn('验证码错误', 0);
        }
        $data = [
            'user_name' => $userName,
            'password' => $password,
        ];
        self::_setOperateRule('Login', $data);
        if (self::$validator->fails()) {
            return response()->json(['msg' => self::message(), 'code' => 0]);
        }
        $userInfo = self::$admin->where(['user_name' => $userName])->get()->toArray();
        if(empty($userInfo[0]['password'])){
            return $this->jsonReturn('用户名不存在！', 0);
        }
        $hashPassword = $userInfo[0]['password'];
        if (password_verify((string) $password, (string) $hashPassword)) {
            $this->updateInfo($userInfo[0]);
            return response()->json(['msg' => '登陆成功', 'code' => 1]);
        } else {
            return response()->json(['msg' => '密码错误', 'code' => 0]);
        }
    }

    /**
     * 更新管理员信息
     * @author luowencai 2017/4/15
     * @param type $userInfo
     */
    public function updateInfo($userInfo) {
        Session::put('adminId', $userInfo['id']);
    }

    /**
     * 登出操作
     * @author luowencai 2017/4/21
     * @return void
     */
    public function logout() {
        Session::forget('adminId');
        return redirect('/');
    }
}
