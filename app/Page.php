<?php

/**
 * 文章实体模型
 * @author luowencai
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model {

    public $timestamps = false;
    protected $fillable = [
        'id', 'title', 'fid', 'project_id', 'add_time', 'content',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 根据id查看文章是否存在
     * @param type $id
     * @param type $type Description 0 为默认 以 id查询 1为以文件夹id查询
     * @return boolean
     */
    public function checkIfExitById($id, $type = 0) {
        $result = '';
        $op = 'id';
        if ($type == 1) {
            $op = 'fid';
        }
        $resInfo = $this->where([$op => $id])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }
    
    /**
     * 根据项目id是否存在
     * @param type $id
     * @return boolean 存在为TRUE 不存在FALSE 
     */
    public function checkIfExitByProjectId($id) {
        $result = '';
        $resInfo = $this->where(['project_id' => $id])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }
    
     /**
     * 根目录的文章标题列表
     * @param type $projectId
     * @return type
     */
    public function rootTitleList($projectId) {
        return $this->where(['project_id' => $projectId, 'fid' => 0])->select(['id', 'title', 'sort'])->get()->toArray();
    }
    
    /**
     * 获取根目录文章内容
     * @param type $projectId
     * @return type
     */
    public function rootPage($projectId) {
        return $this->where(['project_id' => $projectId, 'fid' => 0])->orderBy('sort', 'ASC')->get()->toArray();
    }

}
