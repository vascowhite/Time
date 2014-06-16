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
            $time = (new \DateTime())->format('h:i:s');
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
     * Compares two TimeValues, the following comparisons are accepted:-
     *
     *  '=' returns true if $time is equal to $this
     *  '>' returns true if $time is Greater Than $this
     *  '<' returns true if $time is Less Than $this
     *  '<=' returns true if $time is Less Than or Equal to $this
     *  '>=' returns true if $time is Greater Than or Equal to $this
     *
     * @param TimeValue $time The TimeValue to compare this with
     * @param string    $comparison
     * @return bool
     */
    public function compare(TimeValue $time, $comparison = '=')
    {
        $result = false;
        switch($comparison){
            case '=':
                if($this->seconds === $time->getSeconds()){
                    $result = true;
                }
                break;
            case '>':
                if($time->getSeconds() > $this->seconds){
                    $result = true;
                }
                break;
            case '<':
                if($time->getSeconds() < $this->seconds){
                    $result = true;
                }
                break;
            case '<=':
                if($time->getSeconds() <= $this->seconds){
                    $result = true;
                }
                break;
            case '>=':
                if($time->getSeconds() >= $this->seconds){
                    $result = true;
                }
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTime();
    }

    /**
     * @param TimeValue $time
     *
     * @return bool
     */
    public function isGreaterThan(TimeValue $time)
    {
        return $this->compare($time, '<');
    }

    /**
     * @param TimeValue $time
     *
     * @return bool
     */
    public function isLessThan(TimeValue $time)
    {
        return $this->compare($time, '>');
    }

    /**
     * @param TimeValue $time
     *
     * @return bool
     */
    public function isEqualTo(TimeValue $time)
    {
        return $this->compare($time);
    }
} 