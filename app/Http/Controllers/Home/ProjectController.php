<?php

/**
 * 主要负责关于项目实体的一些操作
 * @author luowencai
 * 
 */

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class ProjectController extends Controller {

    public static $message = [
        'project_name.required' => '名称为空',
        'project_name.max' => '名称超出',
    ]; //验证失败错误提示

    public function __construct() {
        parent::__construct();
        self::_setMessage(self::$message); //初始化错误提示
    }

    /**
     * 添加时需要的规则
     */
    public static function _setAddRule() {
        self::$rule = [
            'project_name' => 'required|max:255',
        ]; //表单验证规则
    }

    /**
     * 编辑
     * @author luowencai 2017/5/1
     * @url /home/project-doEdit
     */
    public function edit() {
        $this->projectId = Input::get('projetcId');
        $projetcName = Input::get('project_name');
        $projectInfo = self::$project->checkIfExitById($this->projectId);
        if (!$projectInfo) {
            return $this->jsonReturn('不存在此项目', 0);
        }
        if (self::$project->checkIfExit($this->uid, $projetcName)) {
            return $this->jsonReturn('项目名已存在', 0);
        }
        if (self::$project->where(['id' => $this->projectId])->update(['project_name' => $projetcName])) {
            return $this->jsonReturn('修改成功', 1);
        } else {
            return $this->jsonReturn('修改失败', 0);
        }
    }

    /**
     * 添加成员
     * @author luowencai 2017/5/1
     * @url /home/addMember
     */
    public function addMember() {
        $memberName = Input::get('member_name');
        $identify = Input::get('identify');
        $this->projectId = Input::get('project_id');
        $resInfo = self::$project->addMember($memberName, $this->projectId, $identify, $this->uid, self::$user, self::$private);
        return $this->jsonReturn($resInfo['msg'], $resInfo['code']);
    }

    /**
     * 编辑成员权限
     * @author luowencai 2017/5/5
     * @url /home/editPrivalidge
     */
    public function editMemberPriv() {
        $privateId = Input::get('private_id');
        $identify = Input::get('identify');
        $resInfo = self::$project->editPrivalidge($privateId, $identify, self::$private);
        return $this->jsonReturn($resInfo['msg'], $resInfo['code']);
    }
    
    /**
     * 删除成员
     * @url /home/delete-privalidge
     * @return type
     */
    public function deletePriv(){
        $privateId = Input::get('private_id');
        if(self::$private->where(['id' => $privateId])->delete()){
            return $this->jsonReturn('操作成功', 1);
        }
        else{
            return $this->jsonReturn('操作失败', 0);
        }
    }

    /**
     * 获取项目对应的成员列表
     * @url /home/member-list?project_id
     */
    public function showMemberList() {
        $this->projectId = Input::get('project_id');
        $size = Input::get('pageSize', 4);
        $member_list = self::$project->memberList($this->projectId, $size, self::$user, self::$private);
        return $this->jsonReturn('成功', 1, $member_list);
    }

    /**
     * 显示列表
     * @author luowencai 2017/5/1
     * @url /home/project-list/page/1
     */
    public function projectList() {
        $pageSize = Input::get('pageSize', 7);
        $projetcList = self::$project->where(['uid' => $this->uid])->paginate($pageSize)->toArray();
        for ($i = 0; $i < count($projetcList['data']); $i++) {
            $projetcList['data'][$i]['add_time'] = date('Y-m-d h:m:s', $projetcList['data'][$i]['add_time']);
        }
        return $this->jsonReturn('ok', 1, $projetcList);
    }

    /**
     * 显示参与的项目列表
     * @author luowencai 2017/5/5
     * @url /home/join-list
     */
    public function joinList() {
        $size = Input::get('pageSize', 4);
        $projetcList = self::$private->joinList($this->uid, $size, self::$project);
        return $this->jsonReturn('ok', 1, $projetcList);
    }

    /**
     * 添加
     * @url /home/addProject
     */
    public function add() {
        $projectName = Input::get('project_name');
        $data = [
            'uid' => $this->uid,
            'project_name' => $projectName,
            'add_time' => time(),
        ];
        $map = [
            'project_name' => $projectName,
        ];
        self::_setOperateRule('Add', $map);
        if (self::$validator->fails()) {
            return $this->jsonReturn(self::message(), 0);
        }
        if (self::$project->checkIfExit($this->uid, $projectName)) {
            return $this->jsonReturn('你已经创建该项目', 0);
        }
        if (self::$project->create($data)) {
            return $this->jsonReturn('创建成功', 1);
        } else {
            return $this->jsonReturn('创建失败', 0);
        }
    }

}
