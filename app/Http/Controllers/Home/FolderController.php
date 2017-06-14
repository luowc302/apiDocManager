<?php

/**
 * 主要负责关于目录实体的操纵
 * @author luowencai
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use App\Libs\Parser;

class FolderController extends Controller {

    //需要权限限制的方法
    public $role = [
        'add', 'edit', 'delete'
    ];
    //权限限制方法用于获取项目id的相关字段
    public $inputName = [
        'folder' => 'id',
        'project' => 'project_id',
    ];
    public static $message = [
        'folder_name.required' => '名称为空',
        'folder_name.max' => '名称超出',
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
            'folder_name' => 'required|max:255',
        ]; //表单验证规则
    }

    /**
     * 添加时需要的规则
     */
    public static function _setEditRule() {
        self::$rule = [
            'folder_name' => 'required|max:255',
        ]; //表单验证规则
    }

    /**
     * 编辑文件夹
     * @author luowencai 2017/5/8
     * @url /home/folder-edit
     */
    public function edit() {
        $folderName = Input::get('folder_name');
        $fid = Input::get('id');
        $sort = Input::get('sort');
        if (!self::$folder->checkIfExit($fid)) {
            return $this->jsonReturn('目录不存在', 0);
        }
        $data = [
            'folder_name' => $folderName,
            'sort' => $sort,
        ];
        if (empty($folderName)) {
            unset($data['folder_name']);
        }
        if (self::$folder->where(['id' => $fid])->update($data)) {
            self::$folder->where(['id' => $fid])->restore();
            return $this->jsonReturn('修改成功', 1);
        } else {
            return $this->jsonReturn('修改失败', 0);
        }
    }

    /**
     * 添加文件夹
     * @author luowencai 2017/5/6
     * @url /home/folder-add
     */
    public function add() {
        $folderName = Input::get('folder_name');
        $followId = Input::get('id', 0);
        $sort = Input::get('sort');
        $this->projectId = Input::get('project_id');
        if (!self::$project->checkIfExitById($this->projectId)) {
            return $this->jsonReturn('项目不存在', 0);
        }
        if ($followId != 0) {
            if (!self::$folder->checkIfExit($followId)) {
                return $this->jsonReturn('目录不存在', 0);
            }
        }
        $map['folder_name'] = $folderName;
        self::_setOperateRule('Add', $map);
        if (self::$validator->fails()) {
            return $this->jsonReturn(self::message(), 0);
        }
        $data = [
            'folder_name' => $folderName,
            'pid' => $followId,
            'project_id' => $this->projectId,
            'sort' => $sort,
            'add_time' => time(),
        ];
        if (self::$folder->create($data)) {
            return $this->jsonReturn('创建成功', 1);
        } else {
            return $this->jsonReturn('创建失败', 0);
        }
    }

    /**
     * 文件夹列表
     * @author luowencai 2017/5/6
     * @url /home/folder-list
     */
    public function folderList() {
        $this->projectId = Input::get('project_id');
        if (!self::$project->checkIfExitById($this->projectId)) {
            return $this->jsonReturn('项目不存在', 0);
        }
        $privalidge = $this->checkPrivalidage();
        if($privalidge == 2){
            return redirect('/roles');
        }
        $resInfo = self::$folder
                ->where(['project_id' => $this->projectId, 'pid' => 0])
                ->with('follow')
                ->with('Pages')
                ->get()
                ->toArray();
        $rootTitleList = self::$page->rootTitleList($this->projectId);
        if (empty($resInfo) && empty($rootTitleList)) {
            return $this->jsonReturn('暂无数据！', 0);
        }
        $i = count($resInfo);
        foreach ($rootTitleList as $value) {
            $resInfo[$i] = $value;
            $i++;
        }
        $res = array_values(arraySort($resInfo, 'sort', 'asc'));
        return $this->jsonReturn('成功！', 1, $res);
    }

    /**
     * 所有文档内容
     * @author luowencai 2017/5/22
     * @url /home/export-word
     */
    public function exportWord() {
        $id = Input::get('id');
        $this->projectId = $id;
        $privalidge = $this->checkPrivalidage();
        if($privalidge == 2){
            return redirect('/roles');
        }
        $paraser = new Parser;
        $pages = self::$page->rootPage($id);
        $folderInfo = self::$folder->where(['project_id' => $id, 'pid' => 0])->with('follows')->with('pageDetails')->orderBy('sort', 'ASC')->get()->toArray();
        $projectName = self::$project->where(['id' => $id])->select('project_name')->get()->toArray();
        $data = constructWord($pages, $folderInfo, $paraser);
        outputWord($data, $projectName[0]['project_name']);
    }

    /**
     * 删除目录并删除其相关文章
     * @author luowencai 2017/5/8
     * @url /home/folder-delete
     */
    public function delete() {
        $fid = Input::get('id');
        $resInfo = self::$folder->deleteFolder($fid, self::$page);
        return $this->jsonReturn($resInfo['msg'], $resInfo['code']);
    }

}
