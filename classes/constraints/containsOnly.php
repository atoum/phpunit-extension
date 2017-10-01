<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters\boolean;
use mageekguy\atoum\asserters\integer;
use mageekguy\atoum\asserters\phpArray;
use mageekguy\atoum\asserters\phpFloat;
use mageekguy\atoum\asserters\phpObject;
use mageekguy\atoum\asserters\phpString;
use mageekguy\atoum\asserters\variable;
use
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\exceptions,
	mageekguy\atoum\tools\variable\analyzer
;

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
			$assertion = self::getAssertion($this->expected);

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
		$assertion = null;
		$transform = null;
		$expected = null;

		switch ($type)
		{
			case 'int':
				$classname = integer::class;
				break;

			case 'float':
				$classname = phpFloat::class;
				break;

			case 'bool':
				$classname = boolean::class;
				break;

			case 'string':
				$classname = phpString::class;
				break;

			case 'array':
				$classname = phpArray::class;
				break;

			case 'null':
				$classname = variable::class;
				$assertion = 'isNull';
				break;

			case 'scalar':
			case 'numeric':
			case 'double':
			case 'real':
			case 'callable':
				$classname = boolean::class;
				$transform = 'is_' . $type;
				$assertion = 'isTrue';
				break;

			case 'boolean':
			case 'integer':
			case 'resource':
				$classname = 'mageekguy\atoum\asserters\\' . $type;
				break;

			default:
				$classname = phpObject::class;

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
