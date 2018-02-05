# Time

[![Build Status](https://travis-ci.org/vascowhite/Time.svg?branch=master)](https://travis-ci.org/vascowhite/Time)

## Introduction
This is a class for dealing with times.

This [time data type][1] represents a period of time. It is expressed in the format 'H:i:s' (a left truncation of the representation of datetime). It is the elapsed time that would be measured on a stop watch that is unaware of date, time zones or DST.

PHP's native `\DatePeriod` is excellent for representing a time period of any length, however it does not lend itself to manipulating time periods or performing calculations with them. Hence, this class was born. Its scope has been limited to hours, minutes and seconds for now as this allows for accurate manipulation without worrying about DST, etc., the `DateTime` classes already have that well covered.

This class can add, subtract, average, sum and compare times. It will also convert a `\DateInterval` object to a `TimeValue` and a `TimeValue` object into a `\DateInterval` object.

## Installation

Install using composer, add the following to composer.json:-

```json
"require": {
    "vascowhite/time": "1.1.0"
}
```

Other methods of installation are possible, but not supported.

## Requirements
Requires PHP >= 5.5.0

---

### TimeValue
This is an __immutable__ class that represents a time data type. It knows nothing about dates, if you need times associated with dates, then PHP's
[`\DateTime`][2] Classes are what you are looking for.

There are various methods available for manipulating and comparing `TimeValue` objects.

`TimeValue` objects implement the `__toString()` magic method, so can be echoed etc..

---

#### TimeValue::__construct()

__Signature:-__
```php
TimeValue __construct(String $time, String $format = 'H:i:s')
```

__Arguments__

`$time` is a string representing a period of time. For example one hour, sixteen minutes and thirty seconds would be represented thus: '01:16:30'.

`$format` Optional format string, defaults to 'H:i:s'. Available formats are 'H:i:s', 'H', 'i', or 's'.

The following are examples of valid formats:-

```php
new TimeValue('12:15:20'); // 12 hours 15 minutes 20 seconds
new TimeValue('12', 'H'); // 12 hours 0 minutes 0 seconds
new TimeValue('12:15', 'H:i'); // 12 hours 15 minutes
new TimeValue('12:15', 'i:s'); // 12 minutes 15 seconds
new TimeValue('20', 's'); // 20 seconds.
```

Although the formats are specified none of the fields are limited to 2 digits. The following are also valid:-

```php
new TimeValue('120:150:200'); // 120 hours 150 minutes 200 seconds Will output '122:33:20'
new TimeValue('00:00:36000'); // 36000 seconds. Will output '10:00:00'
```

__Return__
Returns a `TimeValue` object.

---
#### TimeValue::getSeconds()

__Signature__
```php
Int getSeconds();
```

__Arguments__

None.

__Return__
Returns an integer representing the number of seconds that the `TimeValue` spans.

__Example__
```php
$time = new TimeValue('00:10:10');
echo $time->getSeconds; // Output 610
```
---

### TimeValue::getTime()

__Signature__
```php
String getTime()
```

__Arguments__

None.

__Return__

Returns a string representing the time in the format 'H:i:s'. The 'H' portion will expand to the required number of digits to represent the hour.

__Example__
```php
$time = new TimeValue('00:00:36000');
echo $time->getTime(); // Output "10:00:00"
```

---

### TimeValue::add()

__Signature__
```php
TimeValue add(TimeValue)
```

__Arguments__

The `TimeValue` to be added.

__Return__

Returns a `TimeValue` object set to the appropriate number of seconds.

__Example__
```php
$time = new TimeValue('01:00:00');
echo $time->add(new TimeValue('30', 'i'); // Output "01:30:00"
```

---

### TimeValue::sub()

__Signature__
```php
TimeValue sub(TimeValue)
```

__Arguments__

The `TimeValue` to be subtracted.

__Return__

Returns a `TimeValue` object set to the appropriate number of seconds.

__Example__
```php
$time = new TimeValue('01:00:00');
echo $time->sub(new TimeValue('00:30'); // Output "00:30:00"
```

---

### TimeValue::average()

__Signature__
```php
TimeValue average(TimeValues[])
```

__Arguments__

An array of `TimeValue` objects.

__Return__

Returns a `TimeValue` object set to the average number of seconds of the `TimeValue` objects in the supplied array.

__Example__
```php
$timeValue1 = new TimeValue('00:20:00'); //1200 seconds
$timeValue2 = new TimeValue('00:10:00'); //600 seconds
$timeValue3 = new TimeValue('00:30:00'); //1800 seconds
$average = TimeValue::average([$timeValue1, $timeValue2, $timeValue3]);
echo $average->getSeconds(); //Output = 1200
```

---

### TimeValue::sum()

__Signature__
```php
TimeValue sum(TimeValues[])
```

__Arguments__

An array of `TimeValue` objects.

__Return__

Returns a `TimeValue` object set to the sum the `TimeValue` objects in the supplied array.

__Example__
```php
$timeValue1 = new TimeValue('00:20:00'); //1200 seconds
$timeValue2 = new TimeValue('00:10:00'); //600 seconds
$timeValue3 = new TimeValue('00:30:00'); //1800 seconds
$sum = TimeValue::sum([$timeValue1, $timeValue2, $timeValue3]);
echo $sum->getSeconds(); //Output = 3600
```

---

### TimeValue::createFromDateInterval()

__Signature__
```php
TimeValue createFromDateInterval(\DateInterval, bool)
```

__Arguments__

A `\DateInterval` object.
A Boolean value. If true the returned `\DateInterval` object will represent a negative value. Defaults to false.

__Return__

Returns a `TimeValue` object set to the number of seconds represented by the `\DateInterval` object.

__Example__
```php
$interval = new \DateInterval('P1Y1M6DT14H12M6S');
$timeValue = TimeValue::createFromDateInterval($interval); //34783926 seconds
```

---

###  TimeValue::toDateInterval()

__Signature__
```php
TimeValue||Bool toDateInterval()
```

__Arguments__

None.

__Return__

Returns a `\DateInterval` object with all fields set as if created by `\DateTime::diff()`. Returns `false` if the conversion fails.

__Example__
```php
$timeValue = new TimeValue('34783926', 's');
var_dump($timeValue);
/*
Output
object(DateInterval)[2]
   public 'y' => int 1
   public 'm' => int 1
   public 'd' => int 6
   public 'h' => int 14
   public 'i' => int 12
   public 's' => int 6
   public 'weekday' => int 0
   public 'weekday_behavior' => int 0
   public 'first_last_day_of' => int 0
   public 'invert' => int 0
   public 'days' => int 402
   public 'special_type' => int 0
   public 'special_amount' => int 0
   public 'have_weekday_relative' => int 0
   public 'have_special_relative' => int 0
*/
```

---

### TimeValue::format()

__Signature__
```php
string format(string)
```

__Arguments__  

A string representing the desired format. Uses same formatting as [`\DateInterval::format()`][3]

[1]: http://www.hackcraft.net/web/datetime/#time
[2]: http://php.net/datetime
[3]: http://php.net/manual/en/dateinterval.format.php
