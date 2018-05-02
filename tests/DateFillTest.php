<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DrLenux\DataHelper\DateFill;

/**
 * Class DateFillTest
 */
class DateFillTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testDateFill()
    {
        $class = (new DateFill())
            ->from('2011-01-01')
            ->to('2011-01-02')
            ->interval(DateFill::INTERVAL_HOUR)
            ->format('d H')
            ->fill();
        $this->assertEquals(
            [
                '01 01',
                '01 02',
                '01 03',
                '01 04',
                '01 05',
                '01 06',
                '01 07',
                '01 08',
                '01 09',
                '01 10',
                '01 11',
                '01 12',
                '01 13',
                '01 14',
                '01 15',
                '01 16',
                '01 17',
                '01 18',
                '01 19',
                '01 20',
                '01 21',
                '01 22',
                '01 23'
            ],
            $class
        );
    }
    
    /**
     * @throws Exception
     */
    public function testDesc()
    {
        $class = (new DateFill())
            ->from('2011-01-05')
            ->to('2011-01-01')
            ->inclusiveStart(true)
            ->inclusiveEnd(true)
            ->format('d')
            ->fill();
        $this->assertEquals(
            [
                '05',
                '04',
                '03',
                '02',
                '01'
            ],
            $class
        );
    }
    
    public function testBadInterval()
    {
        $class = (new DateFill())
            ->from('2011-01-01')
            ->to('2011-01-03')
            ->format('d')
            ->interval('error');
        $fill = $class->fill();
        
        $this->assertEquals(
            'DateInterval::__construct(): Unknown or bad format (error)',
            $class->getErrors()[0]->getMessage()
        );
        $this->assertEquals(
            ['02'],
            $fill
        );
    }
}