<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertContainsOnly extends atoum\asserters\phpArray
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (type) of ' . __CLASS__);
		}
		else
		{
			if ($this->analyzer->isString($arguments[0]) === false)
			{
				throw new atoum\exceptions\runtime('Argument #1 (type) of ' . __CLASS__ . ' must be a string');
			}
		}

		if (isset($arguments[1]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #2 (haystack) of ' . __CLASS__);
		}

		$nativeType = isset($arguments[2]) ? (bool) $arguments[2] : true;

		switch (true)
		{
			case $this->analyzer->isArray($arguments[1]):
				$asserter = $this->setWith($arguments[1]);
				break;

			case $arguments[1] instanceof \iterator:
				$asserter = $this->iterator($arguments[1])->toArray;
				break;

			default:
				throw new atoum\exceptions\runtime('Argument #2 (haystack) of ' . __CLASS_ . ' must be an array or an iterator');
		}

		forEach ($asserter->getValue() as $item)
		{
			if ($nativeType === true)
			{
				$asserter->{$arguments[0]}($item, isset($arguments[3]) ? $arguments[3] : null);
			}
			else
			{
				$asserter->object($item)->isInstanceOf($arguments[0], isset($arguments[3]) ? $arguments[3] : null);
			}

		}

		return $this;
	}
}
