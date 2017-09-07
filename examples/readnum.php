<?php

require_once './vendor/autoload.php';

class MyRedis
{
    protected $usersCount = [
        '30',
        '40',
        '50',
    ];

    public function read()
    {
        return array_shift($this->usersCount);
    }
}

$usersCounter = new \MicroLib\VariableValue\ReadBasedValue([new MyRedis(), 'read'], 5);

for ($i = 0; $i < 11; ++$i) {
    echo $usersCounter->get() . PHP_EOL;
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
