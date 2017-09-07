<?php
namespace MicroLibTest\VariableValue;

use MicroLib\VariableValue\TimeBasedValue;
use MicroLib\VariableValue\TimeReader\TimeInterface;
use PHPUnit\Framework\TestCase;

class TimeBasedValueTest extends TestCase
{
    public function testGet()
    {
        /** @var TimeInterface|\PHPUnit_Framework_MockObject_MockObject $timeReaderMock */
        $timeReaderMock = $this->getMockBuilder(TimeInterface::class)
            ->getMock();

        $timeReaderMock->expects(static::exactly(10))
            ->method('getTime')
            ->willReturnOnConsecutiveCalls(1, 1, 1, 1, 2, 2, 2, 3, 3, 3);

        $dataSource = [10, 20, 30];
        $variable = new TimeBasedValue($timeReaderMock, function() use (&$dataSource) {return array_shift($dataSource);}, 1);

        static::assertEquals(10, $variable->get());
        static::assertEquals(10, $variable->get());
        static::assertEquals(10, $variable->get());
        static::assertEquals(20, $variable->get());
        static::assertEquals(20, $variable->get());
        static::assertEquals(30, $variable->get());
        static::assertEquals(30, $variable->get());
    }

    public function testFailsOnInvalidConfiguration()
    {
        /** @var TimeInterface|\PHPUnit_Framework_MockObject_MockObject $timeReaderMock */
        $timeReaderMock = $this->getMockBuilder(TimeInterface::class)
            ->getMock();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('TTL value should be numeric and greater than zero.');
        new TimeBasedValue($timeReaderMock, function() {}, 0);
    }
}
