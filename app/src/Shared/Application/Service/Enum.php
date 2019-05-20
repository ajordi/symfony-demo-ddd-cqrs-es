<?php

namespace App\Shared\Application\Service;

use InvalidArgumentException;
use ReflectionClass;

abstract class Enum
{
    /** @var array */
    protected static $classConstantsCache = [];

    /** @var mixed */
    protected $value;

    public function __construct($value)
    {
        $this->guardIsValid($value);
        $this->value = $value;
    }

    public static function __callStatic(string $name, $arguments): self
    {
        $snake = (strtolower($name) == $name) ? $name : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $name));
        $value = constant(static::class.'::'.strtoupper($snake));

        return new static($value);
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }

    public static function validValues(): array
    {
        $class = get_called_class();
        if (!isset(static::$classConstantsCache[$class])) {
            $reflected = new ReflectionClass($class);
            static::$classConstantsCache[$class] = $reflected->getConstants();
        }
        return array_values(static::$classConstantsCache[$class]);
    }

    public function equals($object): bool
    {
        return ($object instanceof Enum) && ($object == $this);
    }

    public function value()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    protected static function isValid($value): bool
    {
        return in_array($value, static::validValues(), true);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function guardIsValid($value)
    {
        if (!static::isValid($value)) {
            throw new InvalidArgumentException(sprintf('%s value <%s> is invalid', get_class($this), $value));
        }
    }
}
