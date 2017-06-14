<?php

/**
 * 主要负责关于用户实体的一些操作
 * @author luowencai 
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Admin;

class UserController extends Controller {

    public static $admin; //管理员模型
    public static $message = [
        'user_name.required' => '用户名为空',
        'user_name.max' => '用户名超出',
        'password.required' => '密码为空',
        'password.confirmed' => '两次输入的密码不一致',
        'password.min' => '密码小于6位',
        'email.required' => '邮箱为空',
        'email.email' => '邮箱格式错误',
        'vrCode.required' => '验证码为空',
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
            'vrCode' => 'required',
        ]; //表单验证规则
    }

    /**
     * 注册需要的规则
     */
    public static function _setRegistRule() {
        self::$rule = [
            'user_name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]; //表单验证规则
    }

    public static function _setUpdateRule() {
        self::$rule = [
            'password' => 'required|min:6',
            'newPassword' => 'required|confirmed|min:6',
        ]; //表单验证规则
    }

    /**
     * 修改密码
     * @author luowencai 2017/5/6
     * @url /home/update-password
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
        $userInfo = self::$user->where(['id' => $this->uid])->get()->toArray();
        if (empty($userInfo[0]['password'])) {
            return $this->jsonReturn('未知错误！', 0);
        }
        $hashPassword = $userInfo[0]['password'];
        if (password_verify((string) $password, (string) $hashPassword)) {
            if (self::$user->where(['id' => $this->uid])->update(['password' => password_hash((string) $newPassword, PASSWORD_DEFAULT)])) {
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
        $checkBox = Input::get('remember');
        $data = [
            'user_name' => $userName,
            'password' => $password,
            'vrCode' => $vrCode,
        ];
        if (!codeValidate($vrCode)) {
            return $this->jsonReturn('验证码错误', 0);
        }
        self::_setOperateRule('Login', $data);
        if (self::$validator->fails()) {
            return response()->json(['msg' => self::message(), 'code' => 0]);
        }
        $userInfo = self::$user->where(['user_name' => $userName])->get()->toArray();
        if (count($userInfo) == 0) {//如果用户名无法登陆，则尝试邮箱登陆
            $userInfo = self::$user->where(['email' => $userName])->get()->toArray();
        }
        if (empty($userInfo[0]['password'])) {
            return $this->jsonReturn('用户名不存在！', 0);
        }
        $hashPassword = $userInfo[0]['password'];
        if (password_verify((string) $password, (string) $hashPassword)) {
            if ($userInfo[0]['is_used'] == 1) {
                return $this->jsonReturn('你的账号已被停用，请咨询管理员！', 0);
            }
            $this->updateInfo($userInfo[0]);
            $rememberToken = generateCode();
            self::$user->where(['password' => $hashPassword])->update(['remember_token' => $rememberToken]);
            $userInfo['uid'] = $userInfo[0]['id'];
            $userInfo['name'] = $userInfo[0]['user_name'];
            $userInfo['token'] = $rememberToken;
            $cookie = Cookie::forever('user_info', $userInfo);
            return response()->json(['msg' => '登陆成功', 'code' => 1])->withCookie($cookie);
        } else {
            return response()->json(['msg' => '密码错误', 'code' => 0]);
        }
    }

    /**
     * 处理注册请求
     * @author luowencai 2017/4/13
     */
    public function doRegist() {
        $userName = Input::get('user_name');
        $password = Input::get('password');
        $confirmPass = Input::get('confirmPass');
        $email = Input::get('email');
        $map = [
            'user_name' => $userName,
            'password' => $password,
            'password_confirmation' => $confirmPass,
            'email' => $email,
        ];
        self::_setOperateRule('Regist', $map);
        if (self::$validator->fails()) {
            return response()->json(['msg' => self::message(), 'code' => 3]);
        }
        if (self::$admin->checkIfExits($userName) || self::$user->checkIfExits($userName)) {
            return response()->json(['msg' => '用户名不可注册', 'code' => 3]);
        }
        if (self::$user->checkEmailIfExits($email)) {
            return response()->json(['msg' => '邮箱已被注册！', 'code' => 3]);
        }
        $use = config('options.is_used_value')['use'];
        $data = [
            'user_name' => $userName,
            'password' => password_hash((string) $password, PASSWORD_DEFAULT),
            'email' => $email,
            'is_used' => $use,
        ];
        if (self::$user->create($data)) {
            return response()->json(['msg' => '注册成功', 'code' => 1]);
        } else {
            return response()->json(['msg' => '注册失败', 'code' => 0]);
        }
    }

    /**
     * 更新用户信息
     * @author luowencai 2017/4/15
     * @param type $userInfo
     */
    public function updateInfo($userInfo) {
        Session::put('uid', $userInfo['id']);
        Session::put('user_name', $userInfo['user_name']);
    }

    /**
     * 登出操作
     * @author luowencai 2017/4/21
     * @return void
     */
    public function logout() {
        Session::forget('uid');
        Session::forget('user_name');
        $cookie = Cookie::forget('user_info');
        return redirect('/')->withCookie($cookie);
    }

}
