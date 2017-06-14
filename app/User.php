<?php

namespace App;

//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'password', 'identify', 'email', 'is_used',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

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

    /**
     * 检查邮箱是否被用
     * @param type $email
     * @return boolean
     */
    public function checkEmailIfExits($email) {
        $result = '';
        $userInfo = $this->where(['email' => $email])->count();
        $userInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

    /**
     * 根据用户名获取其id
     * @param type $name
     * @return type
     */
    public function nameToId($name) {
        $userInfo = $this->where(['user_name' => $name])->get()->toArray();
        if (empty($userInfo)) {
            return FALSE;
        }
        return $userInfo[0]['id'];
    }

    /**
     * 根据id获取用户名
     * @param type $id
     * @return type
     */
    public function idToName($id) {
        $userInfo = $this->where(['id' => $id])->get()->toArray();
        if (empty($userInfo)) {
            return FALSE;
        }
        return $userInfo[0]['user_name'];
    }

}
