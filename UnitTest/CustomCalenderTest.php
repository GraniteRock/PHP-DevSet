<?php
use PHPUnit\Framework\TestCase;

require_once( __DIR__ . '/../CustomCalender.php');

/**
 * Created by PhpStorm.
 * User: takuya
 * Date: 2017/06/13
 * Time: 14:27
 */
class CustomCalenderTest extends PHPUnit_Framework_TestCase
{
    private $calender;

    private $datetime_format = array(
        "d","D","j","l ","N","S","w","z","W","F","m","M","n","t","L","o",
        "Y","y","a","A","B","g","G","h","H","i","s","u","v","e","I","O",
        "P","T","Z","c","r","U"
    );

    public function setUp()
    {
        $this->calender = new CustomCalender();
    }

    /**
     * private testConstructYMDのテストコード
     */
    public function testConstructYMD()
    {
        $reflection = new \ReflectionClass($this->calender);

        $method = $reflection->getMethod('getConstructYMD');

        $method->setAccessible(true);

        $date = $method->invoke($this->calender,'2017','06','');

        $this->assertEmpty($date);

        $date = $method->invoke($this->calender,'2017','','12');

        $this->assertEmpty($date);

        $date = $method->invoke($this->calender,'','01','17');

        $this->assertEmpty($date);

        $this->assertEquals('2017-01-17',$method->invoke($this->calender,'2017','01','17'));

        // 日付型の取得
        $today = new DateTime();

        //年月日に変数で取得
        $year  = $today->format('Y');
        $month = $today->format('m');
        $day   = $today->format('d');
        $month = sprintf("%02d", $month);
        $day   = sprintf("%02d", $day);

        $check = $method->invoke($this->calender,'2017','06','13');
        $this->assertEquals($year.'-'.$month.'-'.$day,$check);

    }

    function testDayOfTheWeek(){
        $date = new DateTime();
        for($i=0;$i<7;$i++){

            $date = date_add($date,new DateInterval('P1D'));
            $week_num  = $date->format('w');

            $year  = $date->format('Y');
            $month = $date->format('m');
            $day   = $date->format('d');
            $month = sprintf("%02d", $month);
            $day   = sprintf("%02d", $day);

            $this->assertEquals(
                $this->calender->getWeeks($week_num),
                $this->calender->getDayOfTheWeek($year,$month,$day)
            );
        }
    }

    function testToday(){
        $today = new DateTime();

        $this->assertEquals($this->calender->getToday(),$today->format('Y-m-d'));
        foreach($this->datetime_format as $val){
            $this->assertEquals($this->calender->getToday($val),$today->format( $val));
        }
    }

    function testIsToday($year="", $month="", $day="") {
        $today = new DateTime();
        $year  = $today->format('Y');
        $month = $today->format('m');
        $day   = $today->format('d');


        $this->calender->getToday();

        $today = $this->getToday('Y-m-d');

        return $today == $this->getConstructYMD($year,$month,$day) ? true : false;
    }

}
