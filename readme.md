#Time
##Introduction
This is a set of classes for dealing with times.

The [time datatype][1] represents an instant of time that recurs each day. It is expressed in the format hh:mm:ss
(a left truncation of the representation of datetime).  That is to say that a given time today is indistinguishable from
a time with the same value from yesterday or tomorrow.

For example:-

```
08:00 yesterday === 08:00 today === 08:00 tomorrow
```

This class can add, subtract and compare times.

##Installation

Install using composer, add the following to composer.json:-

```json
"require": {
    "vascowhite/time": "dev-master"
}
```

##Classes
###TimeValue
This class represents a time datatype. It knows nothing about dates, if you need times associated with dates, then PHP's
[DateTime][2] Classes are what you are looking for.

It is important to appreciate that a TimeValue can represent a point in time measured from midnight, or an elapsed time,
there is no difference between the two.

There are various methods available for manipulating and comparing TimeValue objects.

TimeValue implements the __toString() magic method, so it can be echoed etc..

####TimeValue::__construct()

__Signature:-__

```php
TimeValue __construct(Mixed $time = null)
```

__Arguments__

`$time` is a string or null.
If null is passed, then a TimeValue object is constructed with the current system time.

If `$time` is a string then it is generally of the format 'hh:mm:ss', although variations on this are allowed.
The following are examples of valid formats:-

```php
new TimeValue('12:15:20'); // 12 hours 15 minutes 20 seconds
new TimeValue('12'); // 12 hours 0 minutes 0 seconds
new TimeValue('12:15'); // 12 hours 15 minutes
new TimeValue('00:00:20'); // 20 seconds.
```

Although the format is specified as 'hh:mm:ss' none of the fields are limited to 2 digits. The following are also valid:-

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

Returns a TimeValue.

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

Returns a TimeValue.

__Example__

```php
$time = new TimeValue('01:00:00');
echo $time->sub(new TimeValue('00:30'); // Output "00:30:00"
```
###TimeValue::compare()


__Signature__

```php
Bool compare(TimeValue, String)
```

__Arguments__

The TimeValue the receiver is to be compared with.  
The comparison to be carried out. The following are accepted:-

 -  '=' returns true if TimeValue is equal to the receiver.
 -  '>' returns true if TimeValue is Greater Than the receiver.
 -  '<' returns true if TimeValue is Less Than the receiver.
 -  '<=' returns true if TimeValue is Less Than or Equal to the receiver.
 -  '>=' returns true if TimeValue is Greater Than or Equal to the receiver.
&nbspc;

 __Return__

 Returns true as above, false otherwise.

 __Example__

```php
$time = new TimeValue('01:00:00');
$time->compare(new TimeValue('01:00:00'), '='); //Returns true
$time->compare(new TimeValue('01:10:00'), '>'); //Returns true
$time->compare(new TimeValue('00:50:00'), '<'); //Returns true
$time->compare(new TimeValue('00:10:00'), '>='); //Returns false
$time->compare(new TimeValue('01:10:00'), '<='); //Returns false
```
---

###TimePeriod

[1]: http://www.hackcraft.net/web/datetime/#time
[2]: http://php.net/datetime
