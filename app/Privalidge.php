<?php

/**
 * 项目实体模型
 * @author luowencai 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privalidge extends Model {

    public $timestamps = false;
    protected $fillable = [
        'uid', 'project_id', 'privalidge',
    ];

    /**
     * 查询是否已在某项目添加权限
     * @param type $uid
     * @param type $projectId
     * @return boolean TRUE 是 FALSE 否
     */
    public function checkIfExit($uid, $projectId) {
        $result = '';
        $resInfo = $this->where(['uid' => $uid, 'project_id' => $projectId])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

    /**
     * 根据id查看权限是否存在
     * @param type $id
     * @return boolean
     */
    public function checkIfExitById($id) {
        $result = '';
        $resInfo = $this->where(['id' => $id])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

    /**
     * 获取加入的项目列表
     * @param type $uid
     * @param type $size
     * @param type $projectModel
     * @return type
     */
    public function joinList($uid, $size, $projectModel) {
        $pravateInfo = $this->where(['uid' => $uid])->paginate($size)->toArray();
        $data = $pravateInfo['data'];
        for ($i = 0; $i < count($data); $i++) {
            $pravateInfo['data'][$i]['project_id'] = $data[$i]['project_id'];
            $pravateInfo['data'][$i]['project_name'] = $projectModel->idToName($data[$i]['project_id']);
            $pravateInfo['data'][$i]['private_name'] = config('options.identify')[$data[$i]['privalidge']];
        }
        return $pravateInfo;
    }

}
