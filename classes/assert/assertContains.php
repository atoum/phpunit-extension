<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertContains extends atoum\asserters\variable
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (needle) of ' . __CLASS__);
		}

		if (isset($arguments[1]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #2 (haystack) of ' . __CLASS__);
		}

		$ignoreCase = isset($arguments[3]) ? (bool) $arguments[3] : false;

		switch (true)
		{
			case $this->analyzer->isArray($arguments[1]):
				$asserter = $this->array($arguments[1]);
				break;

			case $arguments[1] instanceof \iterator:
				$asserter = $this->iterator($arguments[1])->toArray;
				break;

			default:
				$asserter = $this->string($ignoreCase ? strtolower($arguments[1]) : $arguments[1]);
				$arguments[0] = $ignoreCase ? strtolower($arguments[0]) : $arguments[0];
		}

		$asserter->contains($arguments[0]);

		return $this;
	}
}
