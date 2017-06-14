<?php

/**
 * 主要负责前台显示操作
 * @author luowencai
 */

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;
use App\Libs\CurlRequest;

class ApiController extends Controller {
    
    
    /**
     * 显示API测试页面
     * @return type
     */
    public function page(){
        return view('home/api_page');
    }

    /**
     * 测试接口
     * @url /home/run-test
     * @return type
     */
    public function test(){
        $url = Input::get('url');
        $keys = Input::get('keys');
        $values = Input::get('values');
        $cookieKey = Input::get('cookie_keys');
        $cookieValue = Input::get('cookie_values');
        $headerKey = Input::get('header_keys');
        $headerValue = Input::get('header_values');
        if(empty($url)){
            return $this->jsonReturn('接口地址不能为空', 0);
        }
        $method = Input::get('method');
        CurlRequest::$_method = $method;
        if(is_array($cookieKey) && is_array($cookieValue)){
            $cookie =  $this->constructStr($cookieKey, $cookieValue);
            CurlRequest::$_cookie = $cookie;
        }
        if(is_array($headerKey) && is_array($headerValue)){
            $header = $this->constructArray($headerKey, $headerValue);
            CurlRequest::$_header = $header;
        }
        if(is_array($values) && is_array($keys)){
            CurlRequest::$_params = $this->constructArray($keys, $values);
        }
        CurlRequest::$_url = $url;
        $result = CurlRequest::request();
        $encode = mb_detect_encoding($result, array('ASCII','UTF-8','GB2312','GBK','BIG5'), true);
        if($encode != 'UTF-8'){
            $result = iconv($encode,'UTF-8//IGNORE', $result);
        }
        if($result){
            return $this->jsonReturn('ok', 1, $result);
        }
        else{
            return $this->jsonReturn(CurlRequest::$_error, 0);
        }
        
    }


    /**
     * 构建拼接字符串
     * @param type $keyArr
     * @param type $valueArr
     * @return string
     */
    public function constructStr($keyArr, $valueArr){
        $str = '';
        foreach ($keyArr as $value){
            foreach($valueArr as $scValue){
                $str = $value . '=' . $scValue;
            }
        }
        return $str;
    }
    
    /**
     * 构建新数组
     * @param type $keyArr
     * @param type $valueArr
     * @return type
     */
    public function constructArray($keyArr, $valueArr){
        $arr = [];
        for($i = 0; $i < count($keyArr); $i++){
                $arr[$keyArr[$i]] = $valueArr[$i];
        }
        return $arr;
    }
    
    public function uploads($file){
        $request = new Request;
        if ($request->hasFile($file)) {
            $logo = $request->file($file);
            if ($logo != null && $logo->isValid()) {
                $clientName = $logo->getClientOriginalName();
                $extension = $logo->getClientOriginalExtension();
                $fileName = md5(date('ymdhis') . $clientName) . "." . $extension;
                $destinationPath = public_path() . '/img';
                $logo->move($destinationPath, $fileName);
                $logo_path =  '/img' . $fileName;
                return $logo_path;
            }
             else{
            return FALSE;
        }
        }
        else{
            return FALSE;
        }
    }
}