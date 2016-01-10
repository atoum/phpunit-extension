<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertCount extends atoum\asserters\variable
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (expectedCount) of ' . __CLASS__);
		}
		else
		{
			if ($this->getAnalyzer()->isInteger($arguments[0]) === false)
			{
				throw new atoum\exceptions\runtime('Argument #1 (expectedCount) of ' . __CLASS__ . ' must be an integer');
			}
		}

		if (isset($arguments[1]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #2 (haystack) of ' . __CLASS__);
		}

		switch (true)
		{
			case $this->getAnalyzer()->isString($arguments[1]):
				$this->string($arguments[1])->hasLength($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
				break;

			case $this->getAnalyzer()->isArray($arguments[1]):
				$this->array($arguments[1])->hasSize($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
				break;

			case $arguments[1] instanceof \countable:
				$this->sizeOf($arguments[1])->isEqualTo($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
				break;

			case $arguments[1] instanceof \iteratorAggregate:
				$this->integer(iterator_count($arguments[1]->getIterator()))->isEqualTo($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
				break;

			case $arguments[1] instanceof \traversable:
			case $arguments[1] instanceof \iterator:
				$this->integer(iterator_count($arguments[1]))->isEqualTo($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
				break;

			default:
				throw new atoum\exceptions\runtime('Argument #2 (haystack) of ' . __CLASS__ . ' must be a string, an array, a countable object, a traversable object');
		}

		return $this;
	}
}
