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
use \Exception;

class TimeValue {

    const SECONDS_IN_HOUR = 3600;
    const SECONDS_IN_MINUTE = 60;
    private $seconds = 0;

    /**
     * @param string $time   A string representing a time
     * @param string $format A string representing a format (H, i & s are supported)
     * @throws \Exception
     */
    public function __construct($time, $format = 'H:i:s')
    {
        $pattern = '~^(?<sign>\+|-)?' . preg_replace(['~H~', '~i~', '~s~'], '(?<$0>\d+)', $format) . "$~";
        if (!preg_match($pattern, $time, $match)) {
            throw new Exception(sprintf('Format "%s" cannot match time "%s"', $format, $time));
        }

        $this->seconds =
            (isset($match['H']) ? $match['H'] * self::SECONDS_IN_HOUR : 0) +
            (isset($match['i']) ? $match['i'] * self::SECONDS_IN_MINUTE : 0) +
            (isset($match['s']) ? $match['s'] : 0);

        if ($match['sign'] == '-') {
            $this->seconds = -$this->seconds;
        }
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
        $seconds = abs($this->seconds);
        $H = floor($seconds / self::SECONDS_IN_HOUR);
        $i = ($seconds / self::SECONDS_IN_MINUTE) % self::SECONDS_IN_MINUTE;
        $s = $seconds % self::SECONDS_IN_MINUTE;
        return sprintf('%s%02d:%02d:%02d', $this->seconds < 0 ? '-' : '', $H, $i, $s);
    }

    /**
     * Add a TimeValue to $this
     *
     * @param TimeValue $time
     * @return $this
     */
    public function add(TimeValue $time)
    {
        $this->seconds += $time->getSeconds();
        return $this;
    }

    /**
     * Subtract a TimeValue from $this
     *
     * @param TimeValue $time
     * @return $this
     */
    public function sub(TimeValue $time)
    {
        $this->seconds -= $time->getSeconds();
        return $this;
    }

    /**
     * Calculate average of TimeValues
     *
     * @param  TimeValue[] $timeValues
     * @return TimeValue
     */
    public static function average(array $timeValues)
    {
        $count = $sum = 0;
        foreach ($timeValues as $timeValue) {
            if ($timeValue instanceof TimeValue) {
                $count++;
                $sum += $timeValue->getSeconds();
            }
        }
        return new TimeValue($count ? round($sum / $count) : 0, 's');
    }

    /**
     * Calculate sum of TimeValues
     *
     * @param  TimeValue[] $timeValues
     * @return TimeValue
     */
    public static function sum(array $timeValues)
    {
        $sum = 0;
        foreach ($timeValues as $timeValue) {
            if ($timeValue instanceof TimeValue) {
                $sum += $timeValue->getSeconds();
            }
        }
        return new TimeValue($sum, 's');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTime();
    }

}