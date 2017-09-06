<?php
namespace MicroLibTest\VariableValue;

use MicroLib\VariableValue\ReadBasedValue;
use PHPUnit\Framework\TestCase;

class ReadBasedValueTest extends TestCase
{
    public function testGet()
    {
        $dataSource = [10, 20, 30];
        $variable = new ReadBasedValue(function() use (&$dataSource) {
            return array_shift($dataSource);
        }, 2);

        static::assertEquals(10, $variable->get());
        static::assertEquals(10, $variable->get());
        static::assertEquals(20, $variable->get());
        static::assertEquals(20, $variable->get());
        static::assertEquals(30, $variable->get());
    }

    public function testFailsOnInvalidConfiguration()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('MAX reads value should be integer and greater than zero.');
        new ReadBasedValue(function() {}, 0);
    }
}

