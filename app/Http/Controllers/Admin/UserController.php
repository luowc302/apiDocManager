<?php

/**
 * 主要负责关于用户实体的一些操作
 * @author luowencai 
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use Mail;

class UserController extends Controller {

    public static $userEmail;

    /**
     * 重置某成员密码
     * @url /admin/reset
     */
    public function reset() {
        $uid = Input::get('id');
        $Originpsw = generateRandomWords(6);
        $password = password_hash($Originpsw, PASSWORD_BCRYPT);
        $userInfo = self::$user->where(['id' => $uid])->get()->toArray()[0];
        self::$userEmail = $userInfo['email'];
        if (self::$user->where(['id' => $uid])->update(['password' => $password])) {
//            $this->sendEmail($Originpsw);
            return $this->jsonReturn('重置成功，新密码为', 1, ['password' => $Originpsw]);
        } else {
            return $this->jsonReturn('未知错误！', 0);
        }
    }
    
    /**
     * 邮件发送方法
     * @param type $Originpsw
     * @return type
     */
    public function sendEmail($Originpsw) {
        $email = self::$userEmail;
        $flag = Mail::raw('你的密码被管理员重置，新密码："' . $Originpsw . '"，消息来自Api Document Manage。', function($message) use($email){
                    $to = $email;
                    $message->to($to)->subject('密码重置提示');
                });
        if ($flag) {
            
        }
        else{
            return $this->jsonReturn('邮件发送失败，密码已重置为：' . $Originpsw, 0);
        }
    }

    /**
     * 设置账号状态
     * @url /admin/toggle
     * @return type
     */
    public function toggle() {
        $uid = Input::get('id');
        $userInfo = self::$user->where(['id' => $uid])->get()->toArray()[0];
        $is_used = $userInfo['is_used'];
        $is_used == 0 ? $is_used = 1 : $is_used = 0;
        if (self::$user->where(['id' => $uid])->update(['is_used' => $is_used])) {
            return $this->jsonReturn('停用成功', 1);
        } else {
            return $this->jsonReturn('未知错误！', 0);
        }
    }

    /**
     * 显示所有用户列表
     * @url /admin/user-list
     */
    public function userList() {
        $pageSize = Input::get('pageSize', 7);
        $userList = self::$user->select(['id', 'user_name', 'email', 'created_at', 'updated_at', 'is_used'])->paginate($pageSize);
        if (empty($userList->toArray()['data'])) {
            return $this->jsonReturn('无数据', 0);
        } else {
            $i = 0;
            foreach ($userList as $value) {
                $userList[$i]['used_name'] = config('options.is_used_name')[$value['is_used']];
                $userList[$i]['show_name'] = config('options.user_operate_name')[$value['is_used']];
                $i++;
            }
            return $this->jsonReturn('成功', 1, $userList);
        }
    }

}
