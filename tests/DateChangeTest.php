<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DrLenux\DataHelper\DateChange;

/**
 * Class DateChangeTest
 */
class DateChangeTest extends TestCase
{
    /**
     *
     */
    public function testCreateClass()
    {
        $date = '2011-01-01';
        $class = new DateChange($date);
        $this->assertEquals($date, $class->getDate('Y-m-d'));
        
        $date = (new DateChange('2012-12-12'))
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
        new DateChange('asdf');
    }
    
    /**
     *
     */
    public function testAddDay()
    {
        $day = '2011-11-30';
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
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
        $class = new DateChange($day);
        $this->assertEquals(
            '2011-11-30 01:00:00',
            $class
                ->addHour(1)
                ->getDate('Y-m-d H:i:s')
        );
    }

    /**
     * @throws Exception
     */
    public function testSubHour()
    {
        $day = '2011-11-30';
        $class = new DateChange($day);
        $this->assertEquals(
            '2011-11-29 23:00:00',
            $class
                ->subHour(1)
                ->getDate('Y-m-d H:i:s')
        );
    }

    /**
     * @throws Exception
     */
    public function testDiff()
    {
        $day = '2011-11-30';
        $date = new DateChange($day);
        $dateDiff = new DateChange($day);
        $dateDiff->subYear()->subDay();
        $actual = $date->diff($dateDiff)->days;
        $expected = 366;
        $this->assertEquals($expected, $actual);
    }
}