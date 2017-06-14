<?php

/**
 * 项目实体模型
 * @author luowencai 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'id', 'uid', 'project_name', 'member_id_list', 'add_time',
    ];

    /**
     * 根据id查看项目是否存在
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
     * 判断项目名是否存在，同一用户id情况下
     * @author luowencai 2017/4/22
     * @param type $uid
     * @param type $name
     * @param type $flag 是否根据用户id，0 是 1否
     * @return boolean
     */
    public function checkIfExit($uid, $name, $flag = 0) {
        $result = '';
        $flag == 0 ? $mapName = 'uid' : $mapName = 'id';
        $resInfo = $this->where(['project_name' => $name, $mapName => $uid])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

    /**
     * 检查是否项目所有者
     * @param type $uid
     * @param type $projectId
     * @return boolean 是 TRUE 否 FALSE
     */
    public function checkIfOwner($uid, $projectId) {
        $result = '';
        $resInfo = $this->where(['id' => $projectId, 'uid' => $uid])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

    /**
     * 根据id获取用户名
     * @param type $id
     * @return type
     */
    public function idToName($id) {
        $info = $this->where(['id' => $id])->get()->toArray();
        if (empty($info)) {
            return FALSE;
        }
        return $info[0]['project_name'];
    }

    /**
     * 成员列表
     * @param type $project_id 项目id
     * @param type $uid 用户id
     * @param type $page 当前页
     * @param type $size 数据长度
     * @param type $user 用户模型
     * @return int
     */
    public function memberList($project_id, $size, $user, $privateModel) {
        $memberList = $privateModel->where(['project_id' => $project_id])->paginate($size)->toArray();
        $data = $memberList['data'];
        for ($i = 0; $i < count($data); $i++) {
            $memberList['data'][$i]['uid'] = $data[$i]['uid'];
            $memberList['data'][$i]['user_name'] = $user->idToName($data[$i]['uid']);
            $memberList['data'][$i]['indentifyName'] = config('options.identify')[$data[$i]['privalidge']];
        }
        return $memberList;
    }

    /**
     * 添加成员
     * @param type $memberName
     * @param type $project_id
     * @param type $privalidge
     * @param type $ownerId
     * @param type $userModel
     * @return int
     */
    public function addMember($memberName, $projectId, $privalidge, $ownerId, $userModel, $privateModel) {
        $memberId = $userModel->nameToId($memberName);
        if (!$memberId) {
            $resInfo['msg'] = '不存在该用户';
            $resInfo['code'] = 0;
            return $resInfo;
        }
        if ($memberId == $ownerId) {
            $resInfo['msg'] = '你不能添加所有者为组员';
            $resInfo['code'] = 0;
            return $resInfo;
        }
        if ($privateModel->checkIfExit($memberId, $projectId)) {
            $resInfo['msg'] = '请勿重复添加';
            $resInfo['code'] = 0;
            return $resInfo;
        }
        $data = [
            'uid' => $memberId,
            'project_id' => $projectId,
            'privalidge' => $privalidge
        ];
        if ($privateModel->create($data)) {
            $resInfo['msg'] = '添加成功';
            $resInfo['code'] = 1;
        } else {
            $resInfo['msg'] = '添加失败';
            $resInfo['code'] = 0;
        }
        return $resInfo;
    }

    /**
     * 编辑权限
     * @param type $projectId
     * @param type $identify
     * @param type $memberId
     * @return string
     */
    public function editPrivalidge($privateId, $identify, $privateModel) {
        $resInfo['msg'] = '';
        $resInfo['code'] = 0;
        if (!$privateModel->checkIfExitById($privateId)) {
            $resInfo['msg'] = '数据不存在';
            $resInfo['code'] = 0;
            return $resInfo;
        }
        if ($privateModel->where(['id' => $privateId])->update(['privalidge' => $identify])) {
            $resInfo['msg'] = '更新成功';
            $resInfo['code'] = 1;
        } else {
            $resInfo['msg'] = '更新失败';
        }
        return $resInfo;
    }

    /**
     * 项目转交
     * @param type $projectId
     * @param type $uid
     * @return string
     */
    public function transferProject($projectId, $uid, $privateModel) {
        if (!$uid) {
            $resInfo['msg'] = '不存在该用户';
            $resInfo['code'] = 0;
            return $resInfo;
        }
        $resInfo['msg'] = '';
        $resInfo['code'] = 0;
        if ($this->where(['id' => $projectId])->update(['uid' => $uid])) {
            $privateModel->where(['uid' => $uid, 'project_id' => $projectId])->delete();
            $resInfo['msg'] = '更新成功';
            $resInfo['code'] = 1;
        } else {
            $resInfo['msg'] = '更新失败';
        }
        return $resInfo;
    }

    /**
     * 根据projectId删除项目
     * @param type $projectId
     * @param type $pageModel
     * @param type $folderModel
     * @return string|int
     */
    public function deleteProject($projectId, $pageModel, $folderModel) {
        $resInfo['msg'] = '';
        $resInfo['code'] = 0;
        DB::beginTransaction();
        if ($this->where(['id' => $projectId])->delete()) {
            if ($folderModel->checkIfExitByProjectId($projectId)) {
                if ($folderModel->where(['project_id' => $projectId])->forceDelete()) {
                    if ($pageModel->checkIfExitByProjectId($projectId)) {
                        if ($pageModel->where(['project_id' => $projectId])->forceDelete()) {
                            DB::commit();
                            $resInfo['msg'] = '删除成功';
                            $resInfo['code'] = 1;
                            return $resInfo;
                        } else {
                            DB::rollBack();
                            $resInfo['msg'] = '删除失败';
                            return $resInfo;
                        }
                    } else {
                        DB::commit();
                        $resInfo['msg'] = '删除成功';
                        $resInfo['code'] = 1;
                        return $resInfo;
                    }
                } else {
                    DB::rollBack();
                    $resInfo['msg'] = '删除失败';
                    return $resInfo;
                }
            } else {
                DB::commit();
                $resInfo['msg'] = '删除成功';
                $resInfo['code'] = 1;
                return $resInfo;
            }
        } else {
            DB::rollBack();
            $resInfo['msg'] = '删除失败';
            return $resInfo;
        }
    }

}
