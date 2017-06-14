<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Libs;

class CurlRequest {

    public static $_url; //请求的url
    public static $_params = []; //参数
    public static $_method; //请求的方式
    public static $_header; //curl请求头部
    public static $_cookie; //curl cookies
    public static $_error;
    public static $cookiePath = './cookie';

    const POST = 0;
    const GET = 1;

    public static function request() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, self::$cookiePath);
        curl_setopt($ch, CURLOPT_COOKIEJAR, self::$cookiePath);
        if (self::$_method == self::GET) {
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
        if (self::$_method == self::POST) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$_params);
        }
        if (!empty(self::$_cookie)) {
            curl_setopt($ch, CURLOPT_COOKIE, self::$_cookie);
        }
        if (!empty(self::$_header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, self::$_header);
        }
        $result = curl_exec($ch);
        self::$_error = curl_error($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * json转换数组
     * @param type $data
     */
    public static function jsonToArray($data) {
        return json_decode($data, true);
    }

}
