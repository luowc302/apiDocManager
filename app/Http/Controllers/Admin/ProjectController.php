<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class ProjectController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * 超管添加成员至某项目
     * @url /admin/add-member
     */
    public function addMember() {
        $memberName = Input::get('user_name');
        $privalidge = Input::get('privalidge');
        $projectId = Input::get('project_id');
        $resInfo = self::$project->addMember($memberName, $projectId, $privalidge, $this->uid, self::$user, self::$private);
        return $this->jsonReturn($resInfo['msg'], $resInfo['code']);
    }

    /**
     * 编辑成员权限
     * @author luowencai 2017/5/5
     * @url /admin/edit-privalidge
     */
    public function editPrivlidge() {
        $privalidge = Input::get('privalidge');
        $privateId = Input::get('private_id');
        $resInfo = self::$project->editPrivalidge($privateId, $privalidge, self::$private);
        return $this->jsonReturn($resInfo['msg'], $resInfo['code']);
    }
    

    /**
     * 项目列表
     * @author luowencai 2017/5/5
     * @url /admin/project-list
     */
    public function projectList(){
        $pageSize = Input::get('pageSize', 7);
        $projetcList = self::$project->paginate($pageSize)->toArray();
        for ($i = 0; $i < count($projetcList['data']); $i++) {
            $projetcList['data'][$i]['add_time'] = date('Y-m-d h:m:s', $projetcList['data'][$i]['add_time']);
            $projetcList['data'][$i]['user_name'] = self::$user->idToName($projetcList['data'][$i]['uid']);
        }
        return $this->jsonReturn('ok', 1, $projetcList);
    }
    
    /**
     * 删除项目
     * @return type
     */
    public function delete(){
        $this->projectId = Input::get('id');
        $projectInfo = self::$project->checkIfExitById($this->projectId);
        if (!$projectInfo) {
            return $this->jsonReturn('不存在此项目', 0);
        }
        $resInfo = self::$project->deleteProject($this->projectId, self::$page, self::$folder);
        return $this->jsonReturn($resInfo['msg'], $resInfo['code']);
    }
    
    /**
     * 项目转让
     * @url /home/transfer-project
     * @return type
     */
    public function transferProject(){
        $name = Input::get('name');
        $projectId = Input::get('project_id');
        $uid = self::$user->nameToId($name);
        $resInf = self::$project->transferProject($projectId, $uid, self::$private);
        return $this->jsonReturn($resInf['msg'], $resInf['code']);
    }

        /**
     * 获取项目对应的成员列表
     * @url /admin/member-list?project_id
     */
    public function memberList() {
        $this->projectId = Input::get('project_id');
        $size = Input::get('pageSize', 4);
        $member_list = self::$project->memberList($this->projectId, $size, self::$user, self::$private);
        return $this->jsonReturn('成功', 1, $member_list);
    }
}
