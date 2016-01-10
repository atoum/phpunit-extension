<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertEmpty extends atoum\asserters\variable
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (actual) of ' . __CLASS__);
		}

		switch (true)
		{
			case $this->getAnalyzer()->isString($arguments[0]):
				$this->string($arguments[0])->isEmpty(isset($arguments[1]) ? $arguments[1] : null);
				break;

			case $this->getAnalyzer()->isArray($arguments[0]):
				$this->array($arguments[0])->isEmpty(isset($arguments[1]) ? $arguments[1] : null);
				break;

			case $arguments[0] instanceof \countable:
				$this->sizeOf($arguments[0])->isZero(isset($arguments[1]) ? $arguments[1] : null);
				break;

			case $arguments[0] instanceof \iteratorAggregate:
				$this->integer(iterator_count($arguments[0]->getIterator()))->isZero(isset($arguments[1]) ? $arguments[1] : null);
				break;

			case $arguments[0] instanceof \traversable:
			case $arguments[0] instanceof \iterator:
				$this->integer(iterator_count($arguments[0]))->isZero(isset($arguments[1]) ? $arguments[1] : null);
				break;

			default:
				throw new atoum\exceptions\runtime('Argument #1 (actual) of ' . __CLASS__ . ' must be a string, an array, a countable object, a traversable object');
		}

		return $this;
	}
}
