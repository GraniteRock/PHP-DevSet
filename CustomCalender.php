<?php
/**
 * Created by PhpStorm.
 * User: takuya
 * Date: 2017/06/12
 * Time: 14:33
 * Class : CustomCalender
 * Description :2038年問題に対応するため、Datetime型を利用する
 */
require_once (__DIR__ . '/CommonModules.php');
class CustomCalender{
    use CommonModules;
    // コンストラクタ
    function __construct() {
    }

    // デストラクタ
    function __destruct() {
    }

    // 日曜日[0]から土曜日[6]の配列
    private $weeks_array = array("日", "月", "火", "水", "木", "金", "土");

    // for after PHP7
    // define('WEEKS', array(
    // '日',
    // '月',
    // '火',
    // '水',
    // '木',
    // '金',
    // '土'
    // ));

    /**
     * yyy-mm-dd型を返す（共通化用）
     *
     * @param int/string $year  (ex 2017)
     * @param int/string $month (ex 06)
     * @param int/string $day   (ex 11)
     * @return string (yyyy-mm-dd or blank)
     */
    private function getConstructYMD($year, $month, $day){

        foreach(array($year,$month,$day) as $val){
            if ($this->isBlank($val)) return "";
        }
        return  $year . "-" . $month . "-" . $day;
    }

    /**
     * 日付を取得
     *
     * @param int $day_num  (ex 0～6)
     * @return string (ex "日","月","火","水","木","金","土")
     */
    function getWeeks($day_num){
        return $this->weeks_array[$day_num];
    }

    /**
     * 曜日を取得
     *
     * @param int/string $year  (ex 2017)
     * @param int/string $month (ex 06)
     * @param int/string $day   (ex 11)
     * @return string (ex "日","月","火","水","木","金","土")
     */
    function getDayOfTheWeek($year="", $month="", $day=""){
        $date = new DateTime($this->getConstructYMD($year,$month,$day));

        $n = $date->format('w');

        // return $this->WEEKS[$n]; for PHP7
        return $this->weeks_array[$n];
    }

    /**
     * 当日の日付フォーマット内容を返却
     *
     * @param string $date   (ex 'Y-m-d')
     * @return string 当日の情報 (ex '2017-06-13','火','TUE'など)
     */
    function getToday($date = 'Y-m-d') {

        $today = new DateTime();
        return $today->format($date);
    }

    /**
     * 本日かどうかの返却
     *
     * @param int/string $year  (ex 2017)
     * @param int/string $month (ex 06)
     * @param int/string $day   (ex 11)
     * @return bool
     */
    function isToday($year="", $month="", $day="") {

        $today = $this->getToday('Y-m-d');

        return $today == $this->getConstructYMD($year,$month,$day) ? true : false;
    }

    /**
     * 日曜日の日付を返す
     *
     * @param string     $format(Ymd 日付フォーマット)
     * @param int/string $year  (ex 2017)
     * @param int/string $month (ex 06)
     * @param int/string $day   (ex 11)
     * @return bool
     */

    function getSunday($format = 'Ymd',$year="", $month="", $day="") {
        $today = new DateTime($this->getConstructYMD($year,$month,$day));
        $w = $today->format('w');
        $ymd = $today->format('Y-m-d');

        $next_prev = new DateTime($ymd);
        $next_prev->modify("-{$w} day");
        return $next_prev->format($format);

    }

    /**
     * 月曜日の日付を返す
     *
     * @param int/string $year  (ex 2017)
     * @param int/string $month (ex 06)
     * @param int/string $day   (ex 11)
     * @return bool
     */
    function getMonday($format = 'Ymd',$year="", $month="", $day="") {

        $today = new DateTime($this->getConstructYMD($year,$month,$day));
        $w = $today->format('w');
        $ymd = $today->format('Y-m-d');

        if ($w == 0) {
            $d = 6;
        }
        else {
            $d = $w - 1 ;
        }
        $next_prev = new DateTime($ymd);
        $next_prev->modify("-{$d} day");
        return $next_prev->format($format);

    }
    /**
     * 指定日の前後日を取得する
     *
     * @param int/string $n     (ex 1 or -1)
     * @param int/string $year  (ex 2017)
     * @param int/string $month (ex 06)
     * @param int/string $day   (ex 11)
     * @return bool
     */
    function getDiffDay($n = "+0",$year="", $month="", $day="") {

        $next_prev = new DateTime($this->getConstructYMD($year,$month,$day));
        $next_prev->modify($n);
        return $next_prev->format('Ymd');
    }

    /**
     * @param string $date_str_base 基準日時文字列
     * @param string $date_str_comp 比較対象日時文字列
     * @param string $fmt 書式
     * @return int
     */
    function getCompareDatetime($date_str_base='', $date_str_comp='', $fmt='a'){
        $date_base = new DateTime($date_str_base);
        $date_comp = new DateTime($date_str_comp);

        $diff = $date_base->diff($date_comp);

        return $diff->format('%'.$fmt);
    }
}
