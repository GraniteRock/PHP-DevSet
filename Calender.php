<?php
/**
 * Created by PhpStorm.
 * User: takuya
 * Date: 2017/06/13
 * Time: 12:44
 */
require_once (__DIR__ . '/CustomCalender.php');
$cal = new CustomCalender();

//週間カレンダー表示
if (isset($_GET['date'])) {
    //年月日取得
    $ymd = $_GET['date'];

}
else {
    //今週日曜日取得
    $ymd = $cal->getSunday();

}

//年月日に変数で取得
$year  = substr($ymd, 0, 4);
$month = substr($ymd, 4, 2);
$day   = substr($ymd, 6, 2);
$month = sprintf("%01d", $month);
$day   = sprintf("%01d", $day);

$next_week = $cal->getDiffDay('+1 week',$year, $month, $day);
$pre_week  = $cal->getDiffDay('-1 week',$year, $month, $day);

$table = NULL;
//週間の日付出力
for ($i = 0; $i < 7; $i++) {
    $ymd = $cal->getDiffDay( '+'.$i.' day',$year, $month, $day);
    $y = substr($ymd, 0, 4);
    $m = substr($ymd, 4, 2);
    $d = substr($ymd, 6, 2);
    $n = sprintf("%01d", $m);
    $j = sprintf("%01d", $d);
    $t = $j.'日';

    if ($cal->isToday($y, $n, $j)){
        $table .= '<td class="today">'.$t.'</td>'.PHP_EOL;

    }
    else {
        $table .= '<td>'.$t.'</td>'.PHP_EOL;

    }
}


//
//<table id="weekly_cal" class="cal" >
//    <tr>
//        <th colspan="2"><a href="#weekly_cal" data-datetime="<?php echo $pre_week;?>">&laquo; 前週</a></th>
//        <th colspan="3"><?php echo $year;?><!-- 年 --><?php //echo $month;?><!-- 月</td>-->
<!--<th colspan="2"><a href="#weekly_cal" data-datetime="--><?php //echo $next_week;?><!--">次週 &raquo;</a></th>-->
<!--</tr>-->
<!--<tr>-->
<!--    <td>日</td>-->
<!--    <td>月</td>-->
<!--    <td>火</td>-->
<!--    <td>水</td>-->
<!--    <td>木</td>-->
<!--    <td>金</td>-->
<!--    <td>土</td>-->
<!--</tr>-->
<!--<tr>-->
<!--    --><?php //echo $table;?>
<!--</tr>-->
<!--</table>-->
<!--var_dump($table);-->
