<?php

declare(strict_types=1);

namespace DrLenux\DataHelper;

use DateInterval;
use DateTimeZone;
use Exception;
use DateTime;

/**
 * Class DateChange
 *
 * @method $this addDay(int $count = 1)
 * @method $this addMonth(int $count = 1)
 * @method $this addYear(int $count = 1)
 * @method $this addHour(int $count = 1)
 * @method $this addMinute(int $count = 1)
 * @method $this addSeconds(int $count = 1)
 *
 * @method $this subDay(int $count = 1)
 * @method $this subMonth(int $count = 1)
 * @method $this subYear(int $count = 1)
 * @method $this subHour(int $count = 1)
 * @method $this subMinute(int $count = 1)
 * @method $this subSeconds(int $count = 1)
 */
class DateChange
{
    const SECONDS = 'PT{count}S';
    const MINUTE = 'PT{count}M';
    const HOUR = 'PT{count}H';
    const DAY = 'P{count}D';
    const MONTH = 'P{count}M';
    const YEAR = 'P{count}Y';
    
    const TODAY = 'today';
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';
    
    /**
     * @var \DateTime
     */
    private $_date;

    /**
     * DateChange constructor.
     * @param string $date
     * @param DateTimeZone|null $timezone
     * @throws Exception
     */
    public function __construct(string $date = self::TODAY, DateTimeZone $timezone = null)
    {
        $this->_date = new \DateTime($date, $timezone);
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getDate();
    }
    
    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->_date;
    }
    
    /**
     * @param string $format
     * @return string
     */
    public function getDate(string $format = self::DEFAULT_FORMAT): string
    {
        return $this->_date->format($format);
    }
    
    /**
     * @param string $name
     * @param int[] $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $params = preg_split('/(?=[A-Z])/', $name);
        if (
            count($params) === 2 &&
            in_array($params[0], ['sub', 'add']) &&
            defined('static::' . mb_strtoupper($params[1]))
        ) {
            if (!count($arguments)) {
                $arguments[] = 1; //default
            }
            if (count($arguments) === 1 && is_int($arguments[0])) {
                $type = constant('static::' . mb_strtoupper($params[1]));
                $this->{$params[0]}($arguments[0], $type);
                return $this;
            } else {
                throw new Exception('Expected only one integer argument' . $name);
            }
        }
        throw new Exception('Don\'t call method ' . $name);
    }
    
    /**
     * @param int $count
     * @param string $type
     * @throws \Exception
     */
    protected function sub(int $count, string $type)
    {
        $this->_date->sub(new DateInterval(str_replace('{count}', $count, $type)));
    }
    
    /**
     * @param int $count
     * @param string $type
     * @throws \Exception
     */
    protected function add(int $count, string $type)
    {
        $this->_date->add(new DateInterval(str_replace('{count}', $count, $type)));
    }

    /**
     * @param DateChange $date
     * @return bool|DateInterval
     */
    public function diff(DateChange $date): DateInterval
    {
        return $this->getDateTime()->diff($date->getDateTime());
    }
}