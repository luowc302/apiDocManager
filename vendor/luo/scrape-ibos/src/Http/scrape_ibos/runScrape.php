<?php
namespace Http\scrape_ibos;
class runScrape {

    public static $_url = 'http://www.ibos.com.cn/'; //地址
    public static $_pattern = '/<div class="news-info">(.*?)<\/div>/is'; //一级匹配开始定位
    public static $_companyPattern = '/<dl>(.*?)<\/dl>/is'; //二级匹配定位到对应列
    public static $_datePattern = '/<dt>(.*?)<\/dt>/is'; //三级定位到时间
    public static $_namePattern = '/<dd>(.*?)<\/dd>/is'; //三级定位到名称
    public static $_type;

    const JSON = 1;
    const CSV = 0;

    /**
     * 获取首页内容
     * @author luowencai 2017/6/14
     * @return array Description
     */
    public static function getData() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return self::generateData($result);
    }

    /**
     * 进行匹配生成数组
     * @param string $str 需要匹配的数据
     * @author luowencai 2017/6/14
     * @return array Description
     */
    public static function generateData($str) {
        preg_match(self::$_pattern, $str, $match);
        preg_match_all(self::$_companyPattern, $match[1], $scMatch);
        $result = [];
        $i = 0;
        if (empty($scMatch)) {
            return [];
        }
        foreach ($scMatch[0] as $value) {
            preg_match(self::$_datePattern, $value, $date);
            preg_match(self::$_namePattern, $value, $name);
            $array = [$date[1], $name[1]];
            $result[$i] = $array;
            $i++;
        }
        return $result;
    }

    /**
     * 生成csv表格
     * @author luowencai 2017/6/14
     */
    public static function getCsv() {
        ini_set('date.timezone', 'Asia/Shanghai');
        //设置内存占用  
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        //为fputcsv()函数打开文件句柄  
        $output = fopen('php://output', 'w') or die("can't open php://output");
        //告诉浏览器这个是一个csv文件  
        $filename = "授权表" . date('Y-m-d', time());
        header("Content-Type: application/csv");
        header("Content-Disposition: attachment; filename=$filename.csv");
        //输出表头  
        $table_head = array('authorization date', 'company name');
        fputcsv($output, $table_head);
        $emps = self::getData();
        //输出每一行数据到文件中  
        foreach ($emps as $e) {
            $res = [$e[0], iconv('utf-8', 'gbk', $e[1])];
            fputcsv($output, array_values($res));
        }
    }

    /**
     * 运行操作
     * @author luowencai 2017/6/14
     * @return mixed
     */
    public static function run($type = 0) {
        if ($type == self::JSON) {
            $result = self::getData();
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($result, JSON_UNESCAPED_UNICODE));
        } else {
            self::getCsv();
        }
    }

}
