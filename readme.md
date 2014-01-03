#Time
##Introduction
This is a set of classes for dealing with times.

The [time datatype][1] represents an instant of time that recurs each day. It is expressed in the format hh:mm:ss
(a left truncation of the representation of datetime).

That is to say that a given time today is indistinguishable from a time with the same value from yesterday or tomorrow.

For example:-

```PHP
08:00 yesterday === 08:00 today === 08:00 tomorrow
```

This class can add, subtract and compare times.

##Classes
###TimeValue
This class represents a time datatype. It knows nothing about dates, if you need times associated with dates, then PHP's
[DateTime][2] Classes are what you are looking for.

There are various methods available for manipulating and comparing TimeValue objects.

####TimeValue::__construct()

__Signature:-__

```PHP
__construct(Mixed $time = null)
```

###TimePeriod

[1]: http://www.hackcraft.net/web/datetime/#time
[2]: http://php.net/datetime