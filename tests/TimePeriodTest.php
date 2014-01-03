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
 * Time: 16:17
 */

namespace Vascowhite\tests;


use Vascowhite\Time\TimePeriod;
use Vascowhite\Time\TimeValue;

class TimePeriodTest extends \PHPUnit_Framework_TestCase
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

    public function testCanInstantiateWithTimeValue(){
        $testTimePeriod = new TimePeriod(new TimeValue('1:00:00'), new TimeValue('00:30:00'), new TimeValue('03'));
        $this->assertInstanceOf('Vascowhite\Time\TimePeriod', $testTimePeriod, 'Could not instantiate TimePeriod');
    }

    public function testCorrectValuesPresentWithTimeValue()
    {
        $testTimePeriod = new TimePeriod(new TimeValue('1:00:00'), new TimeValue('00:30:00'), new TimeValue('03'));
        $this->assertEquals('01:00:00', $testTimePeriod->current(), 'Wrong first TimeValue obtained');
        foreach($testTimePeriod as $timeValue){
            $result = $timeValue->getTime();
        }
        $this->assertEquals('03:00:00', $result, 'Wrong last TimeValue obtained');
    }

    public function testCanInstantiateWithInt(){
        $testTimePeriod = new TimePeriod(new TimeValue('1:00:00'), new TimeValue('00:30:00'), 5);
        $this->assertInstanceOf('Vascowhite\Time\TimePeriod', $testTimePeriod, 'Could not instantiate int');
    }

    public function testCorrectValuesPresentWithInt()
    {
        $testTimePeriod = new TimePeriod(new TimeValue('1:00:00'), new TimeValue('00:30:00'), 5);
        $this->assertEquals('01:00:00', $testTimePeriod->current(), 'Wrong first TimeValue obtained');
        foreach($testTimePeriod as $timeValue){
            $result = $timeValue->getTime();
        }
        $this->assertEquals('03:00:00', $result, 'Wrong last TimeValue obtained');
    }

} 