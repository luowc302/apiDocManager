<?php

/**
 * 主要负责关于页面的一些操作
 * @author luowencai
 */

namespace App\Http\Controllers\Home;

use App\Libs\Parser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class PageController extends Controller {

    //需要权限限制的方法
    public $role = [
        'add', 'edit', 'delete',
    ];
    //权限限制方法用于获取项目id的相关字段
    public $inputName = [
        'page' => 'id',
        'project' => 'project_id',
        'folder' => 'fid'
    ];
    public static $message = [
        'title.required' => '标题为空',
        'title.max' => '标题超出',
        'fid.required' => '跟随为空',
        'content.required' => '内容为空',
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
            'title' => 'required|max:255',
            'fid' => 'required',
            'content' => 'required',
        ]; //表单验证规则
    }

    /**
     * 添加
     * @author luowencai 2017/5/7
     * @url /home/add-page
     */
    public function add() {
        $title = Input::get('title');
        $follow = Input::get('fid', 0);
        $content = Input::get('textarea-content');
        $sort = Input::get('sort');
        $this->projectId = Input::get('project_id');
        if (!self::$project->checkIfExitById($this->projectId)) {
            return $this->jsonReturn('项目不存在', 0);
        }
        if ($follow != 0) {
            if (!self::$folder->checkIfExit($follow)) {
                return $this->jsonReturn('目录不存在', 0);
            }
        }
        $data = [
            'title' => $title,
            'fid' => $follow,
            'project_id' => $this->projectId,
            'content' => $content,
            'sort' => $sort,
            'add_time' => time(),
        ];
        self::_setOperateRule('Add', $data);
        if (self::$validator->fails()) {
            return $this->jsonReturn(self::message(), 0);
        }
        if (self::$page->create($data)) {
            return $this->jsonReturn('创建成功', 1);
        } else {
            return $this->jsonReturn('创建失败', 0);
        }
    }

    /**
     * 显示文章详情
     * @author luowencai 2017/5/7
     * @url /home/page-detail
     * @return type
     */
    public function pageDetail() {
        define("DOC", 2);
        $pageId = Input::get('id');
        $type = Input::get('type', 0);
        if (empty($pageId)) {
            $this->projectId = Input::get('project_id');
            $pageDetail = self::$page->where(['project_id' => $this->projectId])->orderby('sort')->first();
            if (empty($pageDetail)) {
                if ($type != DOC) {
                    return $this->jsonReturn('无文章！', 0);
                }
            }
            return $this->jsonReturn('ok', 1, $pageDetail);
        } else {
            $pageDetail = self::$page->where(['id' => $pageId])->get()->toArray();
            if (empty($pageDetail)) {
                return $this->jsonReturn('error', 0);
            }
            if ($type != 0) {
                $content = $pageDetail[0]['content'];
                $suffix = 'md';
                if ($type == DOC) {
                    $paraser = new Parser;
                    $content = $paraser->makeHtml($pageDetail[0]['content']);
                    outputWord($content, $pageDetail[0]['title']);
                }
                echo $content;
                header('Content-Type: text/plain');
                header('Content-Disposition: attachment;filename="' . $pageDetail[0]['title'] . '.'. $suffix .'"');
                header('Cache-Control: max-age=0');
            } else {
                return $this->jsonReturn('ok', 1, $pageDetail[0]);
            }
        }
    }

    /**
     * 编辑
     * @author luowencai 2017/5/7
     * @url /home/edit-page
     */
    public function edit() {
        $content = Input::get('textarea-content');
        $title = Input::get('title');
        $pageId = Input::get('id');
        $fid = Input::get('fid');
        $sort = Input::get('sort');
        $data = [
            'content' => $content,
            'title' => $title,
            'fid' => $fid,
            'sort' => $sort,
        ];
        if (self::$page->where(['id' => $pageId])->update($data)) {
            self::$page->where(['id' => $pageId])->restore();
            return $this->jsonReturn('修改成功', 1);
        } else {
            return $this->jsonReturn('修改失败', 0);
        }
    }

    /**
     * 删除
     * @author luowencai 2017/5/8
     * @url /home/delete-page
     */
    public function delete() {
        $pageId = Input::get('id');
        if (!self::$page->checkIfExitById($pageId)) {
            return $this->jsonReturn('文章不存在', 0);
        }
        if (self::$page->where(['id' => $pageId])->delete()) {
            return $this->jsonReturn('删除成功', 1);
        } else {
            return $this->jsonReturn('删除失败', 0);
        }
    }

    /**
     * 模糊查询文章
     * @url /home/search-page
     * @return type
     */
    public function searchPage() {
        $mapName = Input::get('title');
        $projectId = Input::get('project_id');
        if(empty($mapName)){
            $pageList = self::$page
                ->where([])
                ->Where(['project_id' => $projectId])
                ->select(['id', 'fid', 'title'])
                ->orderby('sort', 'ASC')
                ->get()
                ->toArray();
        }
        else{
            $pageList = self::$page
                ->where('title', 'like', '%' . $mapName . '%')
                ->Where(['project_id' => $projectId])
                ->select(['id', 'fid', 'title'])
                ->orderby('sort', 'ASC')
                ->get()
                ->toArray();
        }
        if (empty($pageList)) {
            return $this->jsonReturn('无数据', 0);
        } else {
            return $this->jsonReturn('ok', 1, $pageList);
        }
    }

}
