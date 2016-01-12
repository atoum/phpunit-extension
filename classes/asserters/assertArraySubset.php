<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class assertArraySubset extends atoum\asserters\phpArray
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (subset) of ' . __CLASS__);
		}

		if (isset($arguments[1]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #2 (array) of ' . __CLASS__);
		}

		if ($this->analyzer->isArray($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Argument #1 (subset) of ' . __CLASS__ . ' must be an array');
		}

		$strict = isset($arguments[3]) ? (bool) $arguments[3] : false;
		$failMessage = isset($arguments[2]) ? $arguments[2] : null;

		$this->setWith($arguments[1]);

		foreach ($arguments[0] as $value)
		{
			if ($strict === true)
			{
				$this->strictlyContains($value, $failMessage);
			}
			else
			{
				$this->contains($value, $failMessage);
			}
		}

		return $this;
	}
}
