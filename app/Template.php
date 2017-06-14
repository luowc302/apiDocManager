<?php

/**
 * 项目配置模型
 * @author luowencai 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Template extends Model {

    protected $fillable = [
        'title', 'content', 'add_time'
    ];
    public $timestamps = false;

    /**
     * 生成默认模板数据
     * @param type $param
     */
    public static function insertConfig($param) {
        foreach ($param as $key => $value) {
            DB::table('templates')->insert([
                ['title' => $key, 'content' => file_get_contents($value), 'add_time' => time()],
            ]);
        }
    }
    
    public function allList(){
        $tplListInfo = $this->where([])->select('id', 'title', 'add_time', 'content')->get()->toArray();
        return $tplListInfo;
    }

    /**
     * 获取模板列表
     */
    public function tplList($pageSize){
        $tplListInfo = $this->where([])->select('id', 'title', 'add_time')->paginate($pageSize)->toArray();
        $tplListInfo['data'] = timeTypeChange($tplListInfo['data']);
        return $tplListInfo;
    }

    /**
     * 根据模板id获取模板详情
     * @param type $id
     * @return type
     */
    public function getTplDetail($id){
        return $this->where(['id' => $id])->get()->toArray()[0];
    }

}
