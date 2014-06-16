<?php
/**
    time
    Copyright (C) ${year}  Paul White

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

/**
 * Created by PhpStorm.
 * User: User
 * Date: 02/01/14
 * Time: 09:37
 */

namespace Vascowhite\Time;


class TimePeriod implements \Iterator
{
    /**
     * @var TimeValue
     */
    private $start;

    /**
     * @var TimeValue
     */
    private $interval;

    /**
     * @var TimeValue
     */
    private $end;

    /**
     * @var TimeValue[]
     */
    private $timeValues = [];

    /**
     * @var int
     */
    private $key = 0;

    /**
     * @param TimeValue     $start Start time
     * @param TimeValue     $interval The interval between each time
     * @param TimeValue|Int $end A TimeValue giving the end time or an Int giving number of intervals to repeat.
     */
    public function __construct(TimeValue $start, TimeValue $interval, $end = 1)
    {
        $this->start = $start;
        $this->interval = $interval;
        if($end instanceof TimeValue){
            $this->end = $end;
        }
        if(is_int($end)){
            $this->end = $this->getEnd($end);
        }
        $this->getIntervals();
    }

    private function getIntervals()
    {
        $currTime = clone $this->start;
        while($currTime->compare($this->end, '>=')){
            $this->timeValues[] = $currTime;
            $currTime = $currTime->add($this->interval);
        }
    }

    /**
     * @param Int $end
     * @return TimeValue
     */
    private function getEnd($end)
    {
        $result = clone $this->start;
        for($i = 1; $i < $end; $i++){
            $result = $result->add($this->interval);
        }
        return $result;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return TimeValue
     */
    public function current() {
        return $this->timeValues[$this->key()];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.https://github.com/vascowhite/Time
     */
    public function next() {
        $this->key ++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key() {
        return $this->key;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        return isset($this->timeValues[$this->key]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        $this->key = 0;
    }
}