<?php
/**
Time
Copyright (C) 2014  Paul White

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Vascowhite\Time;


class TimeValue
{
    const SECONDS_IN_HOUR = 3600;
    const SECONDS_IN_MINUTE = 60;
    /**
     * @var int Seconds from midnight.
     */
    private $seconds = 0;

    /**
     * @param String|null $time A string representing a time.
     *
     * If null is passed to constructor then object defaults to current system time.
     * Format is  "hh:mm:ss", mm and ss are optional and will default to 0
     */
    public function __construct($time = null)
    {
        if(!$time){
            $time = (new \DateTime())->format('H:i:s');
        }
        $timeArray = explode(':', $time);
        $hours = (int)$timeArray[0];
        $minutes = 0;
        $seconds = 0;
        if(isset($timeArray[1])){
            $minutes = (int)$timeArray[1];
        }
        if(isset($timeArray[2])){
            $seconds = (int)$timeArray[2];
        }
        $this->seconds = $hours * self::SECONDS_IN_HOUR + $minutes * self::SECONDS_IN_MINUTE + $seconds;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @return string The time format hh:mm:ss
     */
    public function getTime()
    {
        $seconds = $this->seconds;
        $h = floor($seconds / self::SECONDS_IN_HOUR);
        $seconds -= $h * self::SECONDS_IN_HOUR;
        $m = floor($seconds / self::SECONDS_IN_MINUTE);
        $seconds -= $m * self::SECONDS_IN_MINUTE;
        $s = floor($seconds);
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    /**
     * Adds this TimeValue to another
     *
     * @param TimeValue $time
     * @return TimeValue
     */
    public function add(TimeValue $time)
    {
        $seconds = $this->seconds + $time->getSeconds();
        return new TimeValue("00:00:$seconds");
    }

    /**
     * Subtracts a TimeValue from this one.
     *
     * @param TimeValue $time
     * @return TimeValue
     */
    public function sub(TimeValue $time)
    {
        $seconds = $this->seconds - $time->getSeconds();
        //TODO: Does it make sense to have negative time values?
        if($seconds < 0){
            $seconds = 0;
        }
        return new TimeValue("00:00:$seconds");
    }

    /**
     * @param TimeValue[] $timeValues
     * @return TimeValue
     */
    public static function average(array $timeValues)
    {
        $totalSeconds = 0;
        if(count($timeValues) === 0){
            return new TimeValue('00:00:00');
        }
        foreach($timeValues as $timeValue){
            $totalSeconds += $timeValue->getSeconds();
        }
        return new TimeValue('00:00:' . $totalSeconds / count($timeValues));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTime();
    }

}
