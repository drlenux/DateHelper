
[![Latest Stable Version](https://img.shields.io/packagist/v/drlenux/date-helper.svg)](https://packagist.org/packages/drlenux/date-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/drlenux/date-helper.svg)](https://packagist.org/packages/drlenux/date-helper)
[![Build Status](https://travis-ci.org/drlenux/DateHelper.svg?branch=master)](https://travis-ci.org/drlenux/DateHelper)
[![php version](https://img.shields.io/packagist/php-v/drlenux/date-helper.svg)](https://packagist.org/packages/drlenux/date-helper)
[![scrutinizer](https://scrutinizer-ci.com/g/drlenux/DateHelper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drlenux/DateHelper/?branch=master)


Author: `DrLenux`

License: `MIT`

Allow method `DateChange`:
```php
interface DateChange {
    function addDay(int $count = 1)
    function addMonth(int $count = 1)
    function addYear(int $count = 1)
    function addHour(int $count = 1)
    function addMinute(int $count = 1)
    function addSeconds(int $count = 1)

    function subDay(int $count = 1)
    function subMonth(int $count = 1)
    function subYear(int $count = 1)
    function subHour(int $count = 1)
    function subMinute(int $count = 1)
    function subSeconds(int $count = 1)
}
```

Example `DateChange`:
```php
<?php

use DrLenux\DataHelper\DateChange; 

$date = (new DateChange('2012-12-12'))
            ->addYear()
            ->addMonth(2)
            ->subDay();
```

Allow method `DateFill`:
```php
interface DateFill {
    function to(string $to)
    function from(string $from)
    function inclusiveStart(bool $status)
    function inclusiveEnd(bool $status)
    function interval(string $interval)
    function format(string $format)
    function timezone(\DateTimeZone $timezone = null)

    function fill()
    function getErrors()
}
```

Example `DateFill`:
```php
<?php

use DrLenux\DataHelper\DateFill;

$fillArray = (new DateFill())
    ->from('2011-01-01')
    ->to('2011-01-02')
    ->interval(DateFill::INTERVAL_HOUR)
    ->fill();

/*
return [
    '2011-01-01 01:00:00',
    ...
    '2011-01-01 23:00:00'
];
 */
```

Example `Interval`:
```php
<?php

use DrLenux\DataHelper\DateFill;

(new DateFill())
    ->from('2011-10-09 23:59:59')
    ->to('2011-10-09 23:50:00')
    ->interval('PT2M') // every 2 minute
    ->format('H:i:s')
    ->fill(); 

/*
return [
    '23:57:59',
    '23:55:59',
    '23:53:59',
    '23:51:59'
];
*/
```