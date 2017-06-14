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

        $check = $method->invoke($this->calender,$year,$month,$day);
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

    function testIsToday() {
        $today = new DateTime();
        $year  = $today->format('Y');
        $month = $today->format('m');
        $day   = $today->format('d');
        $this->assertNotFalse($this->calender->isToday($year,$month,$day));


        $year='2017';
        $month='05';
        $day='12';

        $this->assertFalse($this->calender->isToday($year,$month,$day));
    }

    function testMonday(){

        $today = new DateTime();
        # もし週始まりを月曜日にするなら、$w + 1　にすればいいはずです
        $w = $today->format('w');

        $today->modify(sprintf("-%d days",($w-1)));

        $this->assertEquals($this->calender->getMonday(),$today->format( 'Ymd'));

        $today = new DateTime('2016-01-05');
        # もし週始まりを月曜日にするなら、$w + 1　にすればいいはずです
        $w = $today->format('w');

        $today->modify(sprintf("-%d days",($w-1)));

        $this->assertEquals($this->calender->getMonday('Ymd','2016','01','05'),$today->format( 'Ymd'));
    }

    function testSunday(){

        $today = new DateTime();

        $w = $today->format('w');

        $today->modify(sprintf("-%d days",($w)));

        $this->assertEquals($this->calender->getSunday(),$today->format( 'Ymd'));

        $today = new DateTime('2016-01-05');
        # もし週始まりを月曜日にするなら、$w + 1　にすればいいはずです
        $w = $today->format('w');

        $today->modify(sprintf("-%d days",($w)));

        $this->assertEquals($this->calender->getSunday('Ymd','2016','01','05'),$today->format( 'Ymd'));
    }

    function testDiffDay(){

        $date = new DateTime();

        for ($i=0;$i < 10;$i++){
            $date->modify(sprintf("-%d days",($i)));

            $year  = $date->format('Y');
            $month = $date->format('m');
            $day   = $date->format('d');

            $this->assertEquals($date->format( 'Ymd'),$this->calender->getDiffDay('-'.$i,$year,$month,$day));
        }

        for ($i=0;$i < 10;$i++){
            $date->modify(sprintf("+%d days",($i)));

            $year  = $date->format('Y');
            $month = $date->format('m');
            $day   = $date->format('d');

            $this->assertEquals($date->format( 'Ymd'),$this->calender->getDiffDay('+'.$i,$year,$month,$day));
        }

    }
}
