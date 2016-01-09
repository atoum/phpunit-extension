<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertInstanceOf extends atoum\asserters\object
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (expected) of ' . __CLASS__);
		}

		if (isset($arguments[1]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #2 (actual) of ' . __CLASS__);
		}

		$this->setWith($arguments[1])->isInstanceOf($arguments[0], isset($arguments[2]) ? $arguments[2] : null);

		return $this;
	}
}