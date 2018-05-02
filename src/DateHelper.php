<?php

declare(strict_types=1);

namespace DrLenux\Helpers;

/**
 * Class DateHelper
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
class DateHelper
{
    const SECONDS = 'PT{count}S';
    const MINUTE = 'PT{count}M';
    const HOUR = 'PT{count}H';
    const DAY = 'P{count}D';
    const MONTH = 'P{count}M';
    const YEAR = 'P{count}Y';
    
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';
    const TODAY = 'today';
    
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
    
    /**
     * @param string $to
     * @param string $format
     * @param bool $inclusiveStart
     * @param bool $inclusiveEnd
     * @param \DateInterval|null $interval
     * @param \DateTimeZone|null $timezone
     * @return array
     * @throws \Exception
     */
    public function fill(
        string $to,
        string $format = self::DEFAULT_FORMAT,
        bool $inclusiveStart = false,
        bool $inclusiveEnd = false,
        \DateInterval $interval = null,
        \DateTimeZone $timezone = null): array
    {
        $to = new \DateTime($to, $timezone);
        if ($interval === null) {
            $interval = new \DateInterval('P1D');
        }
        $result = [];
        $tmp = new \DateTime($this->getDate());
        $vector = ($to > $tmp) ? 'up' : 'down';
        if ($inclusiveStart) {
            $result[] = $tmp->format($format);
        }
        while ($to !== $tmp) {
            switch ($vector) {
                case 'up' :
                    $tmp->add($interval);
                    if ($to > $tmp) {
                        $result[] = $tmp->format($format);
                    } else {
                        $to = $tmp;
                    }
                    break;
                case 'down':
                    $tmp->sub($interval);
                    if ($to < $tmp) {
                        $result[] = $tmp->format($format);
                    } else {
                        $to = $tmp;
                    }
                    break;
            }
        }
        if ($inclusiveEnd) {
            $result[] = $to->format($format);
        }
        return $result;
    }
}