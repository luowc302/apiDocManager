<?php

/**
 * 项目配置模型
 * @author luowencai 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model {

    protected $fillable = [
        'name', 'is_used',
    ];
    public $timestamps = false;

    /**
     * 生成开放功能数据
     * @param type $param
     */
    public static function insertConfig($param) {
        foreach ($param as $key => $value) {
            DB::table('Settings')->insert([
                ['id' => $key, 'name' => $value, 'is_used' => 0],
            ]);
        }
    }

}
