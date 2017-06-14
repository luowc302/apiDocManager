<?php

/**
 * 公共全部模板相关
 * @author luowencai
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class TemplateController extends Controller {

    public static $message = [
        'title.required' => '标题为空',
        'title.max' => '标题超出',
        'content.required' => '内容为空',
    ]; //验证失败错误提示

    /**
     * 添加时需要的规则
     */
    public static function _setAddRule() {
        self::$rule = [
            'title' => 'required|max:255',
            'content' => 'required',
        ]; //表单验证规则
    }
    
    /**
     * 编辑时的规则
     */
    public static function _setEditRule() {
        self::$rule = [
            'title' => 'required|max:255',
            'content' => 'required',
        ]; //表单验证规则
    }

    public function __construct() {
        parent::__construct();
        self::_setMessage(self::$message); //初始化错误提示
    }

    /**
     * 获取模板列表
     * @author luowencai 2017/5/21
     * @url /admin/tpl-list
     * @return type
     */
    public function tplList() {
        $pageSize = Input::get('pageSize', 5);
        return $this->jsonReturn('ok', 1, self::$template->tplList($pageSize));
    }

    /**
     * 添加模板
     * @author luowencai 2017/5/21
     * @url /admin/add-tpl
     * @return type
     */
    public function addTpl() {
        $title = Input::get('title');
        $content = Input::get('content');
        $data = [
            'title' => $title,
            'content' => $content,
            'add_time' => time(),
        ];
        self::_setOperateRule('Add', $data);
        if (self::$validator->fails()) {
            return $this->jsonReturn(self::message(), 0);
        }
        if (self::$template->create($data)) {
            return $this->jsonReturn('创建成功', 1);
        } else {
            return $this->jsonReturn('创建失败', 0);
        }
    }
    
    /**
     * 编辑模板
     * @author luowencai 2017/5/21
     * @url /admin/edit-tpl
     * @return type
     */
    public function editTpl(){
        $id = Input::get('id');
        if(empty($id)){
            return $this->jsonReturn('error', 0);
        }
        $title = Input::get('title');
        $content = Input::get('content');
        $data = [
            'title' => $title,
            'content' => $content,
        ];
        self::_setOperateRule('Edit', $data);
        if (self::$validator->fails()) {
            return $this->jsonReturn(self::message(), 0);
        }
        if(self::$template->where(['id' => $id])->update($data)){
            return $this->jsonReturn('修改成功', 1);
        }
        else{
            return $this->jsonReturn('修改失败', 0);
        }
    }
    
    /**
     * 删除模板
     * @author luowencai 2017/5/21
     * @url /admin/del-tpl
     * @return type
     */
    public function delTpl(){
        $id = Input::get('id');
        if(empty($id)){
            return $this->jsonReturn('error', 0);
        }
        if(self::$template->where(['id' => $id])->delete()){
            return $this->jsonReturn('删除成功', 1);
        }
        else{
            return $this->jsonReturn('删除失败', 0);
        }
    }

    /**
     * 获取模板详情
     * @author luowencai 2017/5/21
     * @url /home/tpl-detail
     * @return type
     */
    public function getTplDetail() {
        $id = Input::get('id');
        if (empty($id)) {
            return $this->jsonReturn('error', 0);
        }
        return $this->jsonReturn('ok', 1, self::$template->getTplDetail($id));
    }

}
