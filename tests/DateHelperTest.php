<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DrLenux\Helpers\DateHelper;

/**
 * Class DateHelperTest
 */
class DateHelperTest extends TestCase
{
    /**
     *
     */
    public function testCreateClass()
    {
        $date = '2011-01-01';
        $class = new DateHelper($date);
        $this->assertEquals($date, $class->getDate('Y-m-d'));
        
        $date = (new DateHelper('2012-12-12'))
            ->addMonth(2)
            ->subSeconds();
        $this->assertEquals(
            '2013-02-11 23:59:59',
            $date->getDate()
        );
    }
    
    /**
     * @expectedException \Exception
     */
    public function testCreateClassFail()
    {
        new DateHelper('asdf');
    }
    
    /**
     *
     */
    public function testAddDay()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-12-01',
            $class
                ->addDay(1)
                ->getDate('Y-m-d')
        );
    }
    
    public function testAddMonth()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-12-30',
            $class
                ->addMonth(1)
                ->getDate('Y-m-d')
        );
    }
    
    public function testAddYear()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2012-11-30',
            $class
                ->addYear(1)
                ->getDate('Y-m-d')
        );
    }
    
    public function testSubDay()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-29',
            $class
                ->subDay(1)
                ->getDate('Y-m-d')
        );
    }
    
    public function testSubMonth()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-10-30',
            $class
                ->subMonth(1)
                ->getDate('Y-m-d')
        );
    }
    
    public function testSubYear()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2010-11-30',
            $class
                ->subYear(1)
                ->getDate('Y-m-d')
        );
    }
    
    public function testAddSeconds()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-30 00:00:01',
            $class
                ->addSeconds(1)
                ->getDate('Y-m-d H:i:s')
        );
    }
    
    public function testSubSeconds()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-29 23:59:59',
            $class
                ->subSeconds(1)
                ->getDate('Y-m-d H:i:s')
        );
    }
    
    public function testAddMinute()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-30 00:01:00',
            $class
                ->addMinute(1)
                ->getDate('Y-m-d H:i:s')
        );
    }
    
    public function testSubMinute()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-29 23:59:00',
            $class
                ->subMinute(1)
                ->getDate('Y-m-d H:i:s')
        );
    }
    
    public function testAddHour()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-30 01:00:00',
            $class
                ->addHour(1)
                ->getDate('Y-m-d H:i:s')
        );
    }
    
    public function testSubHour()
    {
        $day = '2011-11-30';
        $class = new DateHelper($day);
        $this->assertEquals(
            '2011-11-29 23:00:00',
            $class
                ->subHour(1)
                ->getDate('Y-m-d H:i:s')
        );
    }
    
    public function testFill()
    {
        $dateStart = '2011-01-01';
        $dateEnd = '2011-01-05';
        $class = new DateHelper($dateStart);
        $this->assertEquals(
            ['02', '03', '04'],
            $class->fill($dateEnd, 'd')
        );
        $this->assertEquals(
            ['01', '02', '03', '04'],
            $class->fill($dateEnd, 'd', true)
        );
        $this->assertEquals(
            ['02', '03', '04', '05'],
            $class->fill($dateEnd, 'd', false, true)
        );
        $this->assertEquals(
            ['01', '02', '03', '04', '05'],
            $class->fill($dateEnd, 'd', true, true)
        );
        $this->assertEquals(
            ['01', '31', '30'],
            $class->fill('2010-12-30', 'd', true, true)
        );
        $this->assertEquals(
            ['01 00', '01 01', '01 02', '01 03'],
            $class->fill('2011-01-01 03:00:00', 'd H', true, true, new DateInterval('PT1H'))
        );
    }
}