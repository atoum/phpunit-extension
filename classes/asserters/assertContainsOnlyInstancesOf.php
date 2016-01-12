<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class assertContainsOnlyInstancesOf extends assertContainsOnly
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

		parent::setWithArguments(array($arguments[0], $arguments[1], false, isset($arguments[2]) ? $arguments[2] : null));

		return $this;
	}
}
