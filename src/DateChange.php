<?php

declare(strict_types=1);

namespace DrLenux\DataHelper;

/**
 * Class DateChange
 *
 * @method $this addDay(int $count = null)
 * @method $this addMonth(int $count = null)
 * @method $this addYear(int $count)
 * @method $this addHour(int $count)
 * @method $this addMinute(int $count)
 * @method $this addSeconds(int $count = null)
 *
 * @method $this subDay(int $count)
 * @method $this subMonth(int $count)
 * @method $this subYear(int $count)
 * @method $this subHour(int $count)
 * @method $this subMinute(int $count)
 * @method $this subSeconds(int $count = null)
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
     * DateHelper constructor.
     * @param string $date
     * @param \DateTimeZone|null $timezone
     */
    public function __construct(string $date = self::TODAY, \DateTimeZone $timezone = null)
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
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
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
                throw new \Exception('Expected only one integer argument' . $name);
            }
        }
        throw new \Exception('Don\'t call method ' . $name);
    }
    
    /**
     * @param int $count
     * @param string $type
     * @throws \Exception
     */
    protected function sub(int $count, string $type)
    {
        $this->_date->sub(new \DateInterval(str_replace('{count}', $count, $type)));
    }
    
    /**
     * @param int $count
     * @param string $type
     * @throws \Exception
     */
    protected function add(int $count, string $type)
    {
        $this->_date->add(new \DateInterval(str_replace('{count}', $count, $type)));
    }
}