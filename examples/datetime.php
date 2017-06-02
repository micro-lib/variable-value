<?php

require_once './vendor/autoload.php';

/**
 * @property string dateTime
 */
class DateTimeTimeBasedValue extends \MicroLib\VariableValue\TimeBasedValue
{
    public function __construct(callable $variableUpdateCall)
    {
        // Property "dateTime" will be valid for three seconds
        parent::__construct('dateTime', $variableUpdateCall, 3);
    }
}

$variable = new DateTimeTimeBasedValue(
    function () {
        return (new \DateTimeImmutable())->format('Y-m-d H:i:s'); // Variable Value will be updated by this callback
    }
);

for ($i = 0; $i <= 10; ++$i) {
    echo $variable->dateTime . PHP_EOL;
    sleep(1);
}

// Will output, something similar to:

// 2017-06-02 18:59:44
// 2017-06-02 18:59:44
// 2017-06-02 18:59:44
// 2017-06-02 18:59:44
// 2017-06-02 18:59:48
// 2017-06-02 18:59:48
// 2017-06-02 18:59:48
// 2017-06-02 18:59:48
// 2017-06-02 18:59:52
// 2017-06-02 18:59:52
// 2017-06-02 18:59:52
