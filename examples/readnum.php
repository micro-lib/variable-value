<?php

require_once './vendor/autoload.php';

/**
 * @property string count
 */
class UsersCount extends \MicroLib\VariableValue\ReadBasedValue
{
    public function __construct(callable $variableUpdateCall)
    {
        // Property "count" will be refreshed each five reads
        parent::__construct('count', $variableUpdateCall, 5);
    }
}

$usersCount = [
    30,
    40,
    50,
];

$usersCounter = new UsersCount(function () use (&$usersCount) {
    return array_shift($usersCount);
});

for ($i = 0; $i < 11; ++$i) {
    echo $usersCounter->count . PHP_EOL;
}

// Will output

//30
//30
//30
//30
//30
//40
//40
//40
//40
//40
//50
