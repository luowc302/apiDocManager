<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 检查账号是否登陆
 * @return boolean 登陆返回TRUE 未登陆返回FALSE
 */
function checkAuth() {
    $result = TRUE;
    if (empty(Session::get('uid'))) {
        $result = FALSE;
    }
    if (!empty(Cookie::get('user_info'))) {
        $result = TRUE;
    }
    return $result;
}

/**
 * 检查管理员账号是否登陆
 * @return boolean 登陆返回TRUE 未登陆返回FALSE
 */
function checkAdminAuth() {
    $result = TRUE;
    if (empty(Session::get('adminId'))) {
        $result = FALSE;
    }
    return $result;
}

/**
 * 检查锁是否存在
 * @author luowencai 2017/4/13
 * @return boolean 已安装返回true,否则返回false
 */
function checkLock() {
    $lockFile = config('options.lockFiles');
    if (file_exists($lockFile)) {//如果文件存在则无操作
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * 修改配置文件
 * @author luowencai 2017/5/8
 * @param array $config
 * @return boolean TRUE成功 FALSE失败
 */
function updateEnv($config) {
    $file = config('options.envConfig');
    if (file_exists($file)) {//如果文件存在则无操作
    } else {
        $file = config('options.envExample');
        if (!file_exists($file)) {
            return FALSE;
        }
    }
    $array = explode("\n", file_get_contents($file));
    $res = [];
    foreach ($array as $key => $value) {
        if (!empty($value)) {
            $trans = explode("=", $value);
            $res[$trans[0]] = $trans[1];
        }
    }
    foreach ($res as $key => $value) {
        foreach ($config as $scKey => $scValue) {
            if ($key == $scKey) {
                $res[$key] = $scValue;
            }
        }
    }
    $str = '';
    foreach ($res as $key => $value) {
        $str .= $key . '=' . $value . "\n";
    }
    $envfile = fopen(config('options.envConfig'), "w") or die("Unable to open file!");
    fwrite($envfile, $str);
    fclose($envfile);
    return TRUE;
}

/**
 * 验证码验证
 * @author luowencai 2017/5/5
 * @param type $code
 * @return boolean 正确为TRUE 错误为FALSE
 */
function codeValidate($code) {
    $resInfo = FALSE;
    $vrcode = Session::get('validateCode');
    Session::forget('validateCode');
    if (strtoupper($vrcode) == strtoupper($code)) {
        $resInfo = TRUE;
    }
    return $resInfo;
}

/**
 * 生成随机字符串
 * @param type $length
 * @return string
 */
function generateCode() {
    return md5(generateRandomWords($length = 12));
}

/**
 * 生成随机字符串
 * @param type $length
 * @return string
 */
function generateRandomWords($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

/**
 * 获取当前控制器名  
 *  
 * @return string  
 */
function getCurrentControllerName() {
    return getCurrentAction()['controller'];
}

/**
 * 获取当前方法名  
 *  
 * @return string  
 */
function getCurrentMethodName() {
    return getCurrentAction()['method'];
}

/**
 * 获取方法相关
 * @return type
 */
function getCurrentAction() {
    $actionList = \Route::current()->getActionName();
    list($class, $method) = explode('@', $actionList);
    return ['controller' => $class, 'method' => $method];
}

/**
 * 保留目录
 * @param type $array
 * @param int $type 0 跟随目录 1 根目录
 * @return type
 */
function getSelectArray($array, $type = 0) {
    $result = $array;
    if ($type == 0) {
        foreach ($array as $key => $value) {
            if ($value['pid'] == 0) {
                unset($result[$key]);
            }
        }
    }
    if ($type == 1) {
        foreach ($array as $key => $value) {
            if ($value['pid'] != 0) {
                unset($result[$key]);
            }
        }
    }
    $array = array_values($result);
    return $array;
}

/**
 * 多维数组排序
 * @param type $array 要排序的数组
 * @param type $keys 为要用来排序的键名
 * @param type $type 默认为升序排序
 * @return type
 */
function arraySort($array, $keys, $type = 'asc') {
    $keysvalue = $new_array = array();
    foreach ($array as $k => $v) {
        if (!empty($v[$keys]) || $v[$keys] == 0) {
            $keysvalue[$k] = $v[$keys];
        } else {
            $keysvalue[$k] = arraySort($v, $keys, $type);
        }
    }
    $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $array[$k];
    }
    return $new_array;
}

/**
 * 时间戳转时间
 * @param type $array
 * @return type
 */
function timeTypeChange($array) {
    $i = 0;
    foreach ($array as $value) {
        $array[$i]['add_time'] = date('Y-m-d h:m:s', $value['add_time']);
        $i++;
    }
    return $array;
}

/**
 * 导出成word from showdoc
 * @param type $data
 * @param type $fileName
 * @return string
 */
function outputWord($data, $fileName = '') {

    if (empty($data))
        return '';

    $data = '
        <html xmlns:v="urn:schemas-microsoft-com:vml"
        xmlns:o="urn:schemas-microsoft-com:office:office"
        xmlns:w="urn:schemas-microsoft-com:office:word"
        xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta http-equiv=Content-Type content="text/html;  
        charset=utf-8">
		<style type="text/css">
			table  
			{  
				border-collapse: collapse;
				border: none;  
				width: 100%;  
			}  
			td  
			{  
				border: solid #CCC 1px;  
			}  
			.codestyle{
				word-break: break-all;
				background:silver;mso-highlight:silver;
			}
		</style>
        <meta name=ProgId content=Word.Document>
        <meta name=Generator content="Microsoft Word 11">
        <meta name=Originator content="Microsoft Word 11">
        <xml><w:WordDocument><w:View>Print</w:View></xml></head>
        <body>' . $data . '</body></html>';

    $filepath = tmpfile();
    $data = str_replace("<thead>\n<tr>", "<thead><tr style='background-color: rgb(0, 136, 204); color: rgb(255, 255, 255);'>", $data);
    $data = str_replace("<pre><code>", "<table width='100%' class='codestyle'><pre><code>", $data);
    $data = str_replace("</code></pre>", "</code></pre></table>", $data);
    $len = strlen($data);
    fwrite($filepath, $data);
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename={$fileName}.doc");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $fileName . '.doc');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . $len);
    rewind($filepath);
    echo fread($filepath, $len);
}

/**
 * 导出项目所有word
 * @param type $pages
 * @param type $folderInfo
 * @return string
 */
function constructWord($pages, $folderInfo, $paraser) {
    $data = '';
    $parent = 1;
    if ($pages) {
        foreach ($pages as $value) {
            $data .= "<h1>{$parent}、{$value['title']}</h1>";
            $data .= '<div style="margin-left:20px;">';
            $data .= htmlspecialchars_decode($paraser->makeHtml($value['content']));
            $data .= '</div>';
            $parent ++;
        }
    }
    if ($folderInfo) {
        foreach ($folderInfo as $value) {
            $data .= "<h1>{$parent}、{$value['folder_name']}</h1>";
            $data .= '<div style="margin-left:20px;">';
            $child = 1;
            if ($value['page_details']) {
                foreach ($value['page_details'] as $page) {
                    $data .= "<h2>{$parent}.{$child}、{$page['title']}</h2>";
                    $data .= '<div style="margin-left:20px;">';
                    $data .= htmlspecialchars_decode($paraser->makeHtml($page['content']));
                    $data .= '</div>';
                    $child ++;
                }
            }
            if ($value['follows']) {
                $parentTw = 1;
                foreach ($value['follows'] as $thValue) {
                    $data .= "<h2>{$parent}.{$parentTw}、{$thValue['folder_name']}</h2>";
                    $data .= '<div style="margin-left:20px;">';
                    $childTw = 1;
                    if ($thValue['page_details']) {
                        foreach ($thValue['page_details'] as $thPage) {
                            $data .= "<h3>{$parent}.{$parentTw}.{$childTw}、{$thPage['title']}</h3>";
                            $data .= '<div style="margin-left:30px;">';
                            $data .= htmlspecialchars_decode($paraser->makeHtml($thPage['content']));
                            $data .= '</div>';
                            $childTw ++;
                        }
                    }
                    $data .= '</div>';
                    $parentTw ++;
                }
            }
            $data .= '</div>';
            $parent ++;
        }
    }
    return $data;
}
