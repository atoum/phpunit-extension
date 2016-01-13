<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\asserters\object;
use mageekguy\atoum\tools\variable\analyzer;

class containsOnly extends constraint
{
    private $analyzer;
    private $expected;
    private $isNativeType;

    public function __construct($expected, $isNativeType = null, $description = null, analyzer $analyzer = null)
    {
        $this->analyzer = $analyzer ?: new analyzer();
        $this->expected = $expected;
        $this->description = $description;
        $this->isNativeType = $isNativeType;
    }

    protected function matches($actual)
    {
        if (self::isType($this->expected) === false)
        {
            throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must be a valid type or class name');
        }

        if ($this->analyzer->isArray($actual) === false && $actual instanceof \traversable === false)
        {
            throw new \PHPUnit_Framework_Exception('Actual value of ' . __CLASS__ . ' must be an array or a traversable object');
        }

        try
        {
            $assertion = self::getAssertion($this->expected, $this->isNativeType);

            foreach ($actual as $value)
            {
                $assertion($value);
            }
        }
        catch (exceptions\logic $exception)
        {
            throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must be a class instance or class name');
        }
    }

    private static function getAssertion($type)
    {
        $namespace = 'mageekguy\atoum\asserters';
        $assertion = null;
        $transform = null;
        $expected = null;

        switch ($type)
        {
            case 'int':
                $classname = $namespace . '\\integer';
                break;

            case 'float':
                $classname = $namespace . '\\phpFloat';
                break;

            case 'bool':
                $classname = $namespace . '\\boolean';
                break;

            case 'string':
                $classname = $namespace . '\\phpString';
                break;

            case 'array':
                $classname = $namespace . '\\phpArray';
                break;

            case 'null':
                $classname = $namespace . '\\variable';
                $assertion = 'isNull';
                break;

            case 'scalar':
            case 'numeric':
            case 'double':
            case 'real':
            case 'callable':
                $classname = $namespace . '\\boolean';
                $transform = 'is_' . $type;
                $assertion = 'isTrue';
                break;

            case 'boolean':
            case 'integer':
            case 'resource':
                $classname = $namespace . '\\' . $type;
                break;

            default:
                $classname = $namespace . '\\object';

                if ($type !== 'object') {
                    $assertion = 'isInstanceOf';
                    $expected = $type;
                }
        }

        return function($actual) use ($classname, $assertion, $transform, $expected) {
            $asserter = new $classname();

            if ($transform !== null)
            {
                $actual = call_user_func($transform, $actual);
            }

            try
            {
                $asserter->setWith($actual);
            }
            catch (exceptions\logic $exception)
            {
                throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must be a valid type or class name');
            }

            if ($assertion !== null)
            {
                $asserter->{$assertion}($expected);
            }
        };
    }

    private static function isType($type, $isNativeType = null)
    {
        $isClassOrInterface = class_exists($type) || interface_exists($type);
        $isNative = in_array(
            $type,
            array(
                'array',
                'boolean',
                'bool',
                'double',
                'float',
                'integer',
                'int',
                'null',
                'numeric',
                'object',
                'real',
                'resource',
                'string',
                'scalar',
                'callable'
            )
        );

        if ($isNativeType === null)
        {
            return $isClassOrInterface || $isNative;
        }

        return $isNativeType === true ? $isNative : $isClassOrInterface;
    }
}
