<?php

require_once './vendor/autoload.php';

// Data source
$usersCount = [
    '30',
    '40',
    '50',
    '60',
];

$usersCounter = new  \MicroLib\VariableValue\TimeBasedValue(
    new \MicroLib\VariableValue\TimeReader\UnixTimestamp(),
    function () use (&$usersCount) {
    return array_shift($usersCount);
}, 3 # Keep users count in memory for three seconds
);

for ($i = 0; $i <= 10; ++$i) {
    echo sprintf(
        '[%s] %s%s',
        (new DateTime())->format('H:i:s'),
        $usersCounter->get(),
        PHP_EOL
    );
    sleep(1);
}

// Will output, something similar to:
//
//[15:54:34] 30
//[15:54:35] 30
//[15:54:36] 30
//[15:54:37] 40
//[15:54:38] 40
//[15:54:39] 40
//[15:54:40] 50
//[15:54:41] 50
//[15:54:42] 50
//[15:54:43] 60
//[15:54:44] 60
