<?php

/**
 * 项目实体模型
 * @author luowencai 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model {

     public $timestamps = false;
    protected $fillable = [
        'user_name', 'password',
    ];

    /**
     * 创建数据库并初始化数据
     * @param type $param
     */
    public static function createAdmin($param) {
        DB::table('admins')->insert([
            ['user_name' => $param['user_name'], 'password' => password_hash($param['password'], PASSWORD_BCRYPT)],
        ]);
    }
    
    /**
     * 超管重置其密码，需要在服务器添加制定文件方可以操作
     * @author luowencai 2017/4/16
     */
    public static function resetAdmin(){
        $admin = DB::table('admins')->first();
        DB::table('admins')->where(['user_name' => $admin->user_name])->update(['password' => password_hash('123456', PASSWORD_BCRYPT)]);
    }
    
     /**
     * 检查用户名是否存在
     * @param type $userName
     * @return boolean
     */
    public function checkIfExits($userName) {
        $result = '';
        $userInfo = $this->where(['user_name' => $userName])->count();
        $userInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

}
