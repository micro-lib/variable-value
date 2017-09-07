<?php
namespace MicroLib\VariableValue;

class ReadBasedValue implements VariableValueInterface
{
    /** @var mixed */
    private $variableValue;

    /** @var int */
    private $variableMaxReads = 1;

    /** @var int */
    private $variableReads = 0;

    /** @var callable */
    private $variableUpdateCall;

    public function __construct(callable $variableUpdateCall, int $variableMaxReads = 1)
    {
        $this->registerUpdateCall($variableUpdateCall, $variableMaxReads);
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
        $this->setVariableMaxReads($variableMaxReads);
    }

    private function setVariableMaxReads(int $reads): void
    {
        if ($reads > 0) {
            $this->variableMaxReads = $reads;
        } else {
            throw new \InvalidArgumentException('MAX reads value should be integer and greater than zero.');
        }
    }

    /**
     * @return mixed
     */
    protected function getVariableValue()
    {
        if (0 === $this->variableReads || $this->variableReads === $this->variableMaxReads) {
            $this->variableValue = call_user_func($this->variableUpdateCall);
            $this->variableReads = 0;
        }

        ++$this->variableReads;

        return $this->variableValue;
    }

    /**
     * @param callable $call
     *
     * @throws \InvalidArgumentException
     */
    private function setVariableUpdateCall(callable $call): void
    {
        if (false === is_callable($call)) {
            throw new \InvalidArgumentException('Provided function call is not callable');
        }

        $this->variableUpdateCall = $call;
    }
}
