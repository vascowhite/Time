#Time

[![Build Status](https://travis-ci.org/vascowhite/Time.svg?branch=master)](https://travis-ci.org/vascowhite/Time)

##Introduction
This is a class for dealing with times.

The [time datatype][1] represents a period of time. It is expressed in the format hh:mm:ss
(a left truncation of the representation of datetime). It is the elapsed time that would be measured on a stop watch that
is unaware of date, time zones or DST.

PHP's native DateTimePeriod is ecxellent for represent a time period of any length, however it does not lend itself to manipulating
time periods. Hence, this class was born. Its scope has been limited to hours, minutes and seconds for now as this allows for accurate
manipulation without worrying about DST etc, the DateTime classes already have that well covered.

This class can add, subtract and compare times.

##Installation

Install using composer, add the following to composer.json:-

```json
"require": {
    "vascowhite/time": "dev-master"
}
```

###TimeValue
This class represents a time datatype. It knows nothing about dates, if you need times associated with dates, then PHP's
[DateTime][2] Classes are what you are looking for.

There are various methods available for manipulating and comparing TimeValue objects.

TimeValue implements the __toString() magic method, so it can be echoed etc..

####TimeValue::__construct()

__Signature:-__

```php
TimeValue __construct(Mixed $time = null, String $format = 'H:i:s')
```

__Arguments__

`$time` is a string or null.
If null is passed, then a TimeValue object is constructed with the current system time.

`$format` Optional format string, defaults to 'H:i:s'.

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

Returns a TimeValue object.

####TimeValue::getSeconds()

__Signature__

```php
Int getSeconds();
```

__Arguments__

None.

__Return__

Returns an integer representing the number of seconds that the TimeValue spans.

__Example__

```php
$time = new TimeValue('00:10:10');
echo $time->getSeconds; // Output 610
```

###TimeValue::getTime()

__Signature__

```php
String getTime()
```

__Arguments__

None.

__Return__

Returns a string representing the time in the format 'hh:mm:ss'.
The 'hh' portion will expand to the required number of digits to represent the hour.

__Example__

```php
$time = new TimeValue('00:00:36000');
echo $time->getTime(); // Output "10:00:00"
```

###TimeValue::add()

__Signature__

```php
TimeValue add(TimeValue)
```

__Arguments__

The TimeValue to be added to the receiver.

__Return__

Returns the receiver after the addition has been performed.

__Example__

```php
$time = new TimeValue('01:00:00');
echo $time->add(new TimeValue('00:30'); // Output "01:30:00"
```

###TimeValue::sub()

__Signature__

```php
TimeValue sub(TimeValue)
```

__Arguments__

The TimeValue to be subtracted from the receiver.

__Return__

Returns the receiver after the subtraction has been performed.

__Example__

```php
$time = new TimeValue('01:00:00');
echo $time->sub(new TimeValue('00:30'); // Output "00:30:00"
```

###TimeValue::average()


__Signature__

```php
TimeValue average(TimeValues[])
```


__Arguments__

An array of TimeValue objects.


__Return__

Returns a TimeValue object set to the average number of seconds of the 
TimeValue objects in the supplied array.


__Example__


```php
$timeValue1 = new TimeValue('00:20:00'); //1200 seconds
$timeValue2 = new TimeValue('00:10:00'); //600 seconds
$timeValue3 = new TimeValue('00:30:00'); //1800 seconds

$average = TimeValue::average([$timeValue1, $timeValue2, $timeValue3]);
echo $average->getSeconds(); //Output = 1200
```

###TimeValue::sum()


__Signature__

```php
TimeValue sum(TimeValues[])
```


__Arguments__

An array of TimeValue objects.


__Return__

Returns a TimeValue object set to the sum the 
TimeValue objects in the supplied array.


__Example__


```php
$timeValue1 = new TimeValue('00:20:00'); //1200 seconds
$timeValue2 = new TimeValue('00:10:00'); //600 seconds
$timeValue3 = new TimeValue('00:30:00'); //1800 seconds

$sum = TimeValue::sum([$timeValue1, $timeValue2, $timeValue3]);
echo $sum->getSeconds(); //Output = 3600
```

---

[1]: http://www.hackcraft.net/web/datetime/#time
[2]: http://php.net/datetime
