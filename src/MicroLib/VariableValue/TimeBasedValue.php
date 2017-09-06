<?php
namespace MicroLib\VariableValue;

use MicroLib\VariableValue\TimeReader\TimeInterface;

class TimeBasedValue implements VariableValueInterface
{
    /** @var mixed */
    private $variableValue;

    /** @var int */
    private $variableTtl = 0;

    /** @var int */
    private $variableUpdatedAt = 0;

    /** @var callable */
    private $variableUpdateCall;

    /** @var TimeInterface */
    private $timeReader;

    /**
     * @param TimeInterface $timeReader
     * @param callable $variableUpdateCall
     * @param int $variableTtl default:1 second
     */
    public function __construct(TimeInterface $timeReader, callable $variableUpdateCall, $variableTtl = 1)
    {
        $this->registerUpdateCall($variableUpdateCall, $variableTtl);
        $this->timeReader = $timeReader;
        $this->variableUpdatedAt = 0 - $variableTtl;
    }

    /**
     * @inheritdoc
     */
    public function get()
    {
        return $this->getVariableValue();
    }

    private function registerUpdateCall(callable $call, int $variableMaxReads = 1): void
    {
        $this->setVariableUpdateCall($call);
        $this->setVariableValueTtl($variableMaxReads);
    }

    private function setVariableValueTtl(int $ttl): void
    {
        if ($ttl >= 1) {
            $this->variableTtl = $ttl;
        } else {
            throw new \InvalidArgumentException('TTL value should be numeric and greater than zero.');
        }
    }

    /**
     * @return mixed
     */
    private function getVariableValue()
    {
        if ($this->variableUpdatedAt + $this->variableTtl <= $this->getTime()) {
            $this->variableValue = call_user_func($this->variableUpdateCall);
            $this->variableUpdatedAt = $this->getTime();
        }

        return $this->variableValue;
    }

    protected function getTime(): int
    {
        return $this->timeReader->getTime();
    }

    private function setVariableUpdateCall(callable $call): void
    {
        if (false === is_callable($call)) {
            throw new \InvalidArgumentException('Provided function call is not callable');
        }

        $this->variableUpdateCall = $call;
    }
}
