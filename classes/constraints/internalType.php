<?php

namespace mageekguy\atoum\phpunit\constraints;

use PHPUnit;
use
	mageekguy\atoum\asserters,
	mageekguy\atoum\exceptions\logic,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer,
	mageekguy\atoum\exceptions
;

class internalType extends constraint
{
	private $expected;
	private $analyzer;

	public function __construct($expected, $description = null, analyzer $analyzer = null)
	{
		$this->expected = $expected;
		$this->description = $description;
		$this->analyzer = $analyzer ?: new analyzer();
	}

	protected function matches($actual)
	{
		if (self::isType($this->expected) === false)
		{
			throw new PHPUnit\Framework\Exception('Expected value of ' . __CLASS__ . ' must be a valid type');
		}

		$assertion = self::getAssertion($this->expected, $this->analyzer);
		$assertion($actual);
	}

	private static function getAssertion($type, analyzer $analyzer)
	{
		$namespace = 'mageekguy\atoum\asserters';
		$assertion = null;
		$transform = null;
		$expected = null;
		$message = null;

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
				$message = '%s is not a %s';
				break;

			case 'boolean':
			case 'integer':
			case 'resource':
				$classname = $namespace . '\\' . $type;
				break;

			default:
				$classname = $namespace . '\\object';
		}

		return function($actual) use ($classname, $assertion, $transform, $expected, $message, $type, $analyzer) {
			$asserter = new $classname();

			if ($message !== null)
			{
				$message = sprintf($message, $analyzer->getTypeOf($actual), $type);
			}

			if ($transform !== null)
			{
				$actual = call_user_func($transform, $actual);
			}

			try
			{
				$asserter->setWith($actual, $message);
			}
			catch (exceptions\logic $exception)
			{
				throw new PHPUnit\Framework\Exception('Expected value of ' . __CLASS__ . ' must be a valid type or class name');
			}

			if ($assertion !== null)
			{
				$asserter->{$assertion}($expected ?: $message, $message);
			}
		};
	}

	private static function isType($type)
	{
		return in_array(
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
	}
}
