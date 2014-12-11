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

namespace Vascowhite\tests;
use Vascowhite\Time\TimeValue;
use \Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class TimeValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TimeValue
     */
    private $testTimeValue;

    /**
     * @var \DateTime
     */
    private $testDateTime;

    /**
     * @var Int
     */
    private $testSeconds;

    public function setUp()
    {
        $this->testDateTime = new \DateTime();
        $this->testTimeValue = new TimeValue($this->testDateTime->format('H:i:s'));
        $this->testSeconds = (int)$this->testDateTime->format('H') * TimeValue::SECONDS_IN_HOUR
            + (int)$this->testDateTime->format('i') * TimeValue::SECONDS_IN_MINUTE
            + (int)$this->testDateTime->format('s');
    }

    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Vascowhite\Time\TimeValue', $this->testTimeValue, "Could not instantiate TimeValue");
    }

    public function testCanGetSeconds()
    {
        $this->assertEquals($this->testSeconds, $this->testTimeValue->getSeconds(), "Cannot get seconds");
        $testTimeValue = new TimeValue('12:00:00');
        $this->assertEquals(43200, $testTimeValue->getSeconds(), "Cannot get seconds");
        $testTimeValue = new TimeValue('23:59:59');
        $this->assertEquals(86399, $testTimeValue->getSeconds(), "Cannot get seconds");
        $testTimeValue = new TimeValue('12:00:00');
        $this->assertEquals(43200, $testTimeValue->getSeconds(), "Cannot get seconds");
    }

    public function testCanGetTime()
    {
        $this->assertEquals($this->testDateTime->format('H:i:s'), $this->testTimeValue->getTime(), "Time string not valid");
        $timeString = '08:05:22';
        $testTimeValue = new TimeValue($timeString);
        $this->assertEquals($timeString, $testTimeValue->getTime(), "Time string not valid");
        $timeString = '23:59:59';
        $testTimeValue = new TimeValue($timeString);
        $this->assertEquals($timeString, $testTimeValue->getTime(), "Time string not valid");
    }

    public function testCanAdd()
    {
        $testTimeValue = new TimeValue('00:00:100');
        $this->assertEquals(200, $testTimeValue->add(new TimeValue('00:00:100'))->getSeconds(), "Can't add up!");
    }

    public function testCanSubtract()
    {
        $testTimeValue = new TimeValue('00:00:100');
        $this->assertEquals(0, $testTimeValue->sub(new TimeValue('00:00:100'))->getSeconds(), "1Can't subtract!");

        $testTimeValue = new TimeValue('00:00:200');
        $this->assertEquals(0, $testTimeValue->sub(new TimeValue('00:00:200'))->getSeconds(), "2Can't subtract!");

        $testTimeValue = new TimeValue('00:00:200');
        $this->assertEquals(100, $testTimeValue->sub(new TimeValue('00:00:100'))->getSeconds(), "3Can't subtract!");
    }

    public function testAddAndSubtractReturnCorrectFormat()
    {
        $testTimeValue = new TimeValue('01:30', 'H:i');
        $this->assertEquals('02:00:00', $testTimeValue->add(new TimeValue('00:30', 'H:i'))->getTime());

        $testTimeValue = new TimeValue('01:30', 'H:i');
        $this->assertEquals('01:00:00', $testTimeValue->sub(new TimeValue('00:30', 'H:i'))->getTime());
    }

    public function testCanCompareEquals()
    {
        $testTimeValue = new TimeValue('12', 'H');
        $this->assertTrue($testTimeValue == new TimeValue('12', 'H'), 'Cannot compare equals.');
        $this->assertFalse($testTimeValue == new TimeValue('12:01', 'H:i'), 'Cannot compare equals.');
    }

    public function testCanCompareGreaterThan()
    {
        $testTimeValue = new TimeValue('12', 'H');
        $this->assertTrue($testTimeValue < new TimeValue('12:30', 'H:i'), '#1 Cannot compare equals.');
        $this->assertFalse($testTimeValue < new TimeValue('12', 'H'), '#2 Cannot compare equals.');
        $this->assertFalse($testTimeValue < new TimeValue('11', 'H'), '#3 Cannot compare equals.');
    }

    public function testCanCompareLessThan()
    {
        $testTimeValue = new TimeValue('12', 'H');
        $this->assertTrue($testTimeValue > new TimeValue('11:30', 'H:i'), 'Cannot compare equals.');
        $this->assertFalse($testTimeValue > new TimeValue('12', 'H'), 'Cannot compare equals.');
        $this->assertFalse($testTimeValue > new TimeValue('12:30', 'H:i'), 'Cannot compare equals.');
    }

    public function testCompareLessThanOrEqualTo()
    {
        $testTimeValue = new TimeValue('12', 'H');
        $this->assertTrue($testTimeValue >= new TimeValue('11:30', 'H:i'), 'Cannot compare <=.');
        $this->assertTrue($testTimeValue >= new TimeValue('12', 'H'), 'Cannot compare <=.');
        $this->assertFalse($testTimeValue >= new TimeValue('12:30', 'H:i'), 'Cannot compare <=.');
    }

    public function testCompareGreaterThanOrEqualTo(){
        $testTimeValue = new TimeValue('12', 'H');
        $this->assertTrue($testTimeValue <= new TimeValue('12:30', 'H:i'), 'Cannot compare >=.');
        $this->assertTrue($testTimeValue <= new TimeValue('12', 'H'), 'Cannot compare >=.');
        $this->assertFalse($testTimeValue <= new TimeValue('11:30', 'H:i'), 'Cannot compare >=.');
    }

    public function testCompareReturnsFalseOnWrongSymbol()
    {
        // this is meaningless, since PHP will already trigger notice when multiplying objects with *, or comparing with unknown symbol
        #$testTimeValue = new TimeValue('12', 'H');
        #$this->assertFalse($testTimeValue->compare(new TimeValue('11:30'), '*'), 'Cannot compare equals.');
    }

    public function testCanEcho(){
        $testTimeValue = new TimeValue('00:00:00');
        ob_start();
        echo $testTimeValue;
        $result = ob_get_clean();
        $this->assertEquals('00:00:00', $result, "Cannot echo!");
    }

    public function testPassInvalidTime()
    {
        try {
            new TimeValue(' ');
        } catch (Exception $e) {
            $this->assertTrue(true, "Could not deal with invalid time string");
        }
    }

    public function testCanCalculateAverage()
    {
        //With a populated array
        $timeValue1 = new TimeValue('00:20:00'); //1200 seconds
        $timeValue2 = new TimeValue('00:10:00'); //600 seconds
        $timeValue3 = new TimeValue('00:30:00'); //1800 seconds
        $this->assertEquals(1200, TimeValue::average([$timeValue1, $timeValue2, $timeValue3])->getSeconds(), "Could not calculate average");

        //With an empty array
        $this->assertEquals(0, TimeValue::average([])->getSeconds(), "Could not calculate average on empty array");
    }

    public function testCanSumTimeValues()
    {
        $testValues = [
            $timeValue1 = new TimeValue('00:20:00'), //1200 seconds
            $timeValue2 = new TimeValue('00:10:00'), //600 seconds
            $timeValue3 = new TimeValue('00:30:00'), //1800 seconds
            $timeValue4 = new TimeValue('-30', 's'), //30 seconds
        ];
        $this->assertEquals(3570, TimeValue::sum($testValues)->getSeconds(), "Could not sum TimeValues");
    }

}
