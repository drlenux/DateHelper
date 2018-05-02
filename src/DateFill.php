<?php

declare(strict_types=1);

namespace DrLenux\DataHelper;

/**
 * Class DateFill
 * @package DrLenux\DataHelper
 * 
 * @method $this to(string $to)
 * @method $this from(string $from)
 * @method $this inclusiveStart(bool $status)
 * @method $this inclusiveEnd(bool $status)
 * @method $this interval(string $interval)
 * @method $this format(string $format)
 * @method $this timezone(\DateTimeZone $timezone = null)
 */
class DateFill
{
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';
    
    const INTERVAL_SECOND = 'PT1S';
    const INTERVAL_MINUTE = 'PT1M';
    const INTERVAL_HOUR = 'PT1H';
    const INTERVAL_DAY = 'P1D';
    const INTERVAL_MONTH = 'P1M';
    const INTERVAL_YEAR = 'P1Y';
    
    /**
     * @var \DateTime
     */
    private $_from;
    /**
     * @var \DateTime
     */
    private $_to;
    /**
     * @var bool
     */
    private $_inclusiveStart;
    /**
     * @var bool
     */
    private $_inclusiveEnd;
    /**
     * @var \DateInterval
     */
    private $_interval;
    /**
     * @var \DateTimeZone|null
     */
    private $_timezone;
    
    /**
     * @var string
     */
    private $_format;
    /**
     * @var \Exception[]
     */
    private $_errors = [];
    
    /**
     * @var array
     */
    private $_params = [];
    
    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     */
    public function __call(string $name, array $arguments)
    {
        if (count($arguments)) {
            $this->_params[$name] = $arguments[0];
        }
        return $this;
    }
    
    /**
     * @return string[]
     * @throws \Exception
     */
    public function fill():array
    {
        $this->fillData();
        $results = [];
        if ($this->_inclusiveStart) {
            $results[] = $this->_from->format($this->_format);
        }
        if ($this->_to > $this->_from) {
            $this->fillAscending($results);
        } else {
            $this->fillDescending($results);
        }
        if ($this->_inclusiveEnd) {
            $results[] = $this->_to->format($this->_format);
        }
        return $results;
    }
    
    /**
     * @param array $results
     */
    private function fillAscending(array &$results)
    {
        $from = clone $this->_from;
        while ($from !== $this->_to) {
            $from->add($this->_interval);
            if ($from >= $this->_to) {
                $from = $this->_to;
            } else {
                $results[] = $from->format($this->_format);
            }
        }
    }
    
    /**
     * @param array $results
     */
    private function fillDescending(array &$results)
    {
        $from = clone $this->_from;
        while ($from !== $this->_to) {
            $from->sub($this->_interval);
            if ($from <= $this->_to) {
                $from = $this->_to;
            } else {
                $results[] = $from->format($this->_format);
            }
        }
    }
    
    /**
     * @throws \Exception
     */
    private function fillData()
    {
        $this->fillTimezone();
        $this->fillFromAndTo();
        $this->fillInterval();
        $this->fillInclusive();
        $this->fillFormat();
    }
    
    /**
     *
     */
    private function fillFormat()
    {
        $this->_format = $this->_params['format'] ?? DateFill::DEFAULT_FORMAT;
    }
    
    /**
     *
     */
    private function fillInclusive()
    {
        $this->_inclusiveStart = (bool) ($this->_params['inclusiveStart'] ?? false);
        $this->_inclusiveEnd = (bool) ($this->_params['inclusiveEnd'] ?? false);
    }
    
    /**
     * @throws \Exception
     */
    private function fillInterval()
    {
        try {
            $this->_interval = new \DateInterval(
                $this->_params['interval'] ?? DateFill::INTERVAL_DAY
            );
        } catch (\Exception $e) {
            $this->_errors[] = $e;
            $this->_interval = new \DateInterval(DateFill::INTERVAL_DAY);
        }
    }
    
    /**
     *
     */
    private function fillFromAndTo()
    {
        $this->_from = new \DateTime(
            $this->_params['from'] ?? 'now',
            $this->_timezone
        );
        $this->_to = new \DateTime(
            $this->_params['to'] ?? 'now',
            $this->_timezone
        );
    }
    
    /**
     *
     */
    private function fillTimezone()
    {
        if (
            isset($this->_params['timezone']) &&
            $this->_params['timezone'] instanceof \DateTimeZone
        ) {
            $this->_timezone = $this->_params['timezone'];
        } else {
            $this->_timezone = null;
        }
    }
    
    /**
     * @return \Exception[]
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}