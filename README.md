Author: `DrLenux`

License: `MIT`

Allow method `DateChange`:
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
```

Example `DateChange`:
```php
<?php

use DrLenux\DataHelper\DateChange; 

$date = (new DateChange('2012-12-12'))
            ->addMonth(2)
            ->subSeconds();
```

Allow method `DateFill`:
```php
to(string $to)
from(string $from)
inclusiveStart(bool $status)
inclusiveEnd(bool $status)
interval(string $interval)
format(string $format)
timezone(\DateTimeZone $timezone = null)

fill()
getErrors()
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
    ->interval('PT2M') // every 2 minute
    ->fill(); 
```