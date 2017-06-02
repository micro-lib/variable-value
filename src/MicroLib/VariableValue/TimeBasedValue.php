<?php
namespace MicroLib\VariableValue;

abstract class TimeBasedValue
{
    /** @var string */
    private $property;

    /** @var mixed */
    private $variableValue;

    /** @var int */
    private $variableTtl = 0;

    /** @var int */
    private $variableUpdatedAt = 0;

    /** @var callable */
    private $variableUpdateCall;

    /**
     * @param string   $property
     * @param callable $variableUpdateCall
     * @param int      $variableTtl        default:0
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($property, callable $variableUpdateCall, $variableTtl = 0)
    {
        $this->property = $property;
        $this->variableUpdateCall = $variableUpdateCall;
        $this->setVariableValueTtl($variableTtl);
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
     * @param int      $valueTtl Override constructor value
     *
     * @throws \InvalidArgumentException
     */
    protected function registerUpdateCall(callable $call, $valueTtl = 0)
    {
        $this->setVariableUpdateCall($call);
        $this->setVariableValueTtl($valueTtl);
    }

    /**
     * @param int $ttl
     *
     * @throws \InvalidArgumentException
     */
    private function setVariableValueTtl($ttl)
    {
        if (is_int($ttl) && $ttl >= 0) {
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
        if ($this->variableUpdatedAt + $this->variableTtl < $this->getTime()) {
            $this->variableValue = call_user_func($this->variableUpdateCall);
            $this->variableUpdatedAt = $this->getTime();
        }

        return $this->variableValue;
    }

    /**
     * @return int
     */
    protected function getTime()
    {
        return time();
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
