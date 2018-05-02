Author: `DrLenux`

License: `MIT`

Allow method:
```php
addDay(int $count = 1)
addMonth(int $count = 1)
addYear(int $count = 1)
addHour(int $count = 1)
addMinute(int $count = 1)
addSeconds(int $count = 1)

subDay(int $count = 1)
subMonth(int $count = 1)
subYear(int $count = 1)
subHour(int $count = 1)
subMinute(int $count = 1)
subSeconds(int $count = 1)

fill(
    string $to,
    string $format = self::DEFAULT_FORMAT,
    bool $inclusiveStart = false,
    bool $inclusiveEnd = false,
    \DateInterval $interval = null,
    \DateTimeZone $timezone = null)
```

Example:
```php
<?php

use DrLenux\Helpers\DateHelper; 

$date = (new DateHelper('2012-12-12'))
            ->addMonth(2)
            ->subSeconds();
```
Example `fill()`
```php
<?php

use DrLenux\Helpers\DateHelper;

$startDate = new DateHelper('2011-01-02');
$endDate = (clone $startDate)
    ->addDay()
    ->subHour(6);

$listDay = $startDate->fill(
    $endDate->getDate(),
    'd H',
    true,
    true,
    new \DateInterval('PT1H') // 1 Hour
);

/*
return [
    '02 00',
    '02 01',
    '02 02',
    '02 03',
    '02 04',
    '02 05',
    '02 06'
];
 */
```