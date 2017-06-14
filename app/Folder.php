<?php

/**
 * 目录实体模型
 * @author luowencai
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Folder extends Model {

    public $timestamps = false;
    protected $fillable = [
        'id', 'folder_name', 'pid', 'project_id', 'add_time',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联文档标题
     * @return type
     */
    public function Pages() {
        return $this->hasMany('App\Page', 'fid', 'id')->select('id','fid', 'title', 'sort');
    }
    
    /**
     * 关联文档内容
     * @return type
     */
    public function pageDetails(){
        return $this->hasMany('App\Page', 'fid', 'id');
    }
    
    public function follows(){
        return $this->hasMany('App\Folder', 'pid', 'id')->with('pageDetails');
    }
    
    public function follow(){
        return $this->hasMany('App\Folder', 'pid', 'id')->with('Pages');
    }

    /**
     * 判断文件夹Id是否存在
     * @param type $id
     * @return boolean 存在为TRUE 不存在FALSE 
     */
    public function checkIfExit($id) {
        $result = '';
        $resInfo = $this->where(['id' => $id])->count();
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
     * 检查是否顶级目录
     * @param type $id
     * @return boolean  是 TRUE 否 FALSE 
     */
    public function checkIfRoot($id) {
        $result = '';
        $resInfo = $this->where(['id' => $id, 'pid' => 0])->count();
        $resInfo == 0 ? $result = FALSE : $result = TRUE;
        return $result;
    }

    /**
     * 删除文件夹 根据文件夹id进行删除
     * @param type $fid
     * @param type $pageModel
     * @param type $type 删除类型 默认软删除 0 强制删除 1
     * @return int
     */
    public function deleteFolder($fid, $pageModel, $type = 0) {
        $deleteFunction = 'delete';
        $type == 0 ? null : $deleteFunction = 'forceDelete';
        $resInfo['msg'] = '';
        $resInfo['code'] = 0;
        if (!$this->checkIfExit($fid)) {
            $resInfo['msg'] = '目录不存在';
            $resInfo['code'] = 0;
            return $resInfo;
        }
        DB::beginTransaction(); //开始事务
        if ($this->checkIfRoot($fid)) {//如果是顶级目录
            $fllowId = $this->where(['pid' => $fid])->get()->first()['id'];
            if (!empty($fllowId)) {//如果有次级目录
                $followIdList = $this->followIdlist($fid);
                if ($this->where(['pid' => $fid])->$deleteFunction()) {//先删除次级目录
                    if (!$pageModel->whereIn('fid', $followIdList)->$deleteFunction()) {//删除次级目录跟随的文章
                        DB::rollBack(); //回滚
                        $resInfo['msg'] = '删除失败';
                        $resInfo['code'] = 0;
                        return $resInfo;
                    }
                } else {
                    DB::rollBack(); //回滚
                    $resInfo['msg'] = '次级目录-删除失败';
                    $resInfo['code'] = 0;
                    return $resInfo;
                }
            }
        }
        if ($this->where(['id' => $fid])->$deleteFunction()) {//删除指定的目录
            if ($pageModel->checkIfExitById($fid, 1)) {//查询指定目录是否有跟随文章
                if ($pageModel->where(['fid' => $fid])->$deleteFunction()) {//删除指定目录跟随的文章
                    DB::commit(); //提交事务
                    $resInfo['msg'] = '删除成功';
                    $resInfo['code'] = 1;
                    return $resInfo;
                } else {
                    DB::rollBack(); //回滚
                    $resInfo['msg'] = '指定跟随文章-删除失败';
                    $resInfo['code'] = 0;
                    return $resInfo;
                }
            } else {
                DB::commit(); //提交事务
                $resInfo['msg'] = '删除成功';
                $resInfo['code'] = 1;
                return $resInfo;
            }
        } else {
            DB::rollBack(); //回滚
            $resInfo['msg'] = '指定目录-删除失败';
            $resInfo['code'] = 0;
            return $resInfo;
        }
    }
    /**
     * 获取跟随id集合
     * @param type $fid
     */
    public function followIdlist($fid) {
        $followIdListInfo = $this->where(['pid' => $fid])->select(['id'])->get()->toArray();
        $i = 0;
        $followIdList = [];
        foreach ($followIdListInfo as $value) {
            $followIdList[$i] = $value['id'];
            $i++;
        }
        return $followIdList;
    }

    /**
     * 重新构建文件夹数组列表
     * @param type $array
     * @return type
     */
    public function createFolderList($array) {
        $follow = getSelectArray($array);
        $parent = getSelectArray($array, 1);
        $result = [];
        $i = 0;
        foreach ($parent as $value) {
            $result[$i] = $value;
            $num = 0;
            foreach ($follow as $scValue) {
                if ($value['id'] == $scValue['pid']) {
                    $result[$i]['follow'][$num] = $scValue;
                    $num++;
                }
            }
            if (empty($result[$i]['follow'])) {
                $result[$i]['follow'] = [];
            }
            $i++;
        }
        return $result;
    }

}
