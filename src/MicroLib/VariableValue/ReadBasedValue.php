<?php
namespace MicroLib\VariableValue;

abstract class ReadBasedValue
{
    /** @var string */
    private $property;

    /** @var mixed */
    private $variableValue;

    /** @var int */
    private $variableMaxReads = 1;

    /** @var int */
    private $variableReads = 0;

    /** @var callable */
    private $variableUpdateCall;

    /**
     * @param string   $property
     * @param callable $variableUpdateCall
     * @param int      $variableMaxReads   default:1
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($property, callable $variableUpdateCall, $variableMaxReads = 1)
    {
        $this->property = $property;
        $this->variableUpdateCall = $variableUpdateCall;
        $this->setVariableMaxReads($variableMaxReads);
    }

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ($name === $this->property) {
            return $this->getVariableValue();
        } else {
            throw new \InvalidArgumentException('Unsupported property. Please use "' . $this->property . '"');
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws \BadMethodCallException
     */
    public function __set($name, $value)
    {
        throw new \BadMethodCallException('Setter is disabled.');
    }

    /**
     * @param callable $call
     * @param int      $valueTTL
     *
     * @throws \InvalidArgumentException
     */
    protected function registerUpdateCall(callable $call, $valueTTL = 0)
    {
        $this->setVariableUpdateCall($call);
        $this->setVariableMaxReads($valueTTL);
    }

    /**
     * @param int $reads
     *
     * @throws \InvalidArgumentException
     */
    private function setVariableMaxReads($reads)
    {
        if (is_int($reads) && $reads >= 0) {
            $this->variableMaxReads = $reads;
        } else {
            throw new \InvalidArgumentException('MAX reads value should be integer and greater than zero.');
        }
    }

    /**
     * @return mixed
     */
    private function getVariableValue()
    {
        if (++$this->variableReads <= $this->variableMaxReads) {
            $this->variableValue = call_user_func($this->variableUpdateCall);
            $this->variableReads = 0;
        }

        return $this->variableValue;
    }

    /**
     * @param callable $call
     *
     * @throws \InvalidArgumentException
     */
    private function setVariableUpdateCall(callable $call)
    {
        if (false === is_callable($call)) {
            throw new \InvalidArgumentException('Provided function call is not callable');
        }

        $this->variableUpdateCall = $call;
    }
}
