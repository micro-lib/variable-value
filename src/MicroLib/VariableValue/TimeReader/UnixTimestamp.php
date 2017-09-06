<?php
namespace MicroLib\VariableValue\TimeReader;

final class UnixTimestamp implements TimeInterface
{
    public function getTime(): int
    {
        return time();
    }
}
