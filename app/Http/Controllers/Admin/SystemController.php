<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use App\Setting;

class SystemController extends Controller {

    public static $config;

    public function __construct() {
        parent::__construct();
        self::$config = new Setting;
    }
    
    /**
     * 修改邮箱设置
     * @return type
     */
    public function updateEmail() {
        $config = [
            'MAIL_DRIVER' => Input::get('MAIL_DRIVER'),
            'MAIL_HOST' => Input::get('MAIL_HOST'),
            'MAIL_PORT' => Input::get('MAIL_PORT'),
            'MAIL_USERNAME' => Input::get('MAIL_USERNAME'),
            'MAIL_PASSWORD' => Input::get('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => Input::get('MAIL_ENCRYPTION'),
            'MAIL_ADDRESS' => Input::get('MAIL_ADDRESS'),
        ];
        if(updateEnv($config)){
            return $this->jsonReturn('修改成功', 1);
        }
        else{
            return $this->jsonReturn('修改失败', 0);
        }
    }

    /**
     * 显示可操作功能列表
     * @url /admin/show-function
     * @return type
     */
    public function showFunction() {
        $pageSize = Input::get('pageSize', 7);
        $configInfo = self::$config->paginate($pageSize);
        if (empty($configInfo->toArray()['data'])) {
            return $this->jsonReturn('数据损坏！', 0);
        } else {
            $i = 0;
            foreach ($configInfo as $value) {
                $configInfo[$i]['use_info'] = config('options.is_used')[$value['is_used']];
                $configInfo[$i]['show_name'] = config('options.setting_operate_name')[$value['is_used']];
                $i++;
            }
            return $this->jsonReturn('ok', 1, $configInfo);
        }
    }

    /**
     * 是否开放功能
     * @url /admin/set-function
     */
    public function setFunction() {
        $configId = Input::get('configId');
        $configInfo = self::$config->where(['id' => $configId])->get()->toArray()[0];
        if (!empty($configInfo)) {
            $is_used = $configInfo['is_used'];
            $is_used == 0 ? $is_used = 1 : $is_used = 0;
            if (self::$config->where(['id' => $configId])->update(['is_used' => $is_used])) {
                return $this->jsonReturn('操作成功', 1);
            } else {
                return $this->jsonReturn('操作失败', 0);
            }
        } else {
            return $this->jsonReturn('数据损坏！', 0);
        }
    }

}
