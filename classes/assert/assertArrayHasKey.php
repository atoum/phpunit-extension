<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertArrayHasKey extends atoum\asserters\phpArray
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #1 (key) of ' . __CLASS__);
		}

		if (isset($arguments[1]) === false)
		{
			throw new atoum\exceptions\runtime('Missing argument #2 (array) of ' . __CLASS__);
		}

		$this->setWith($arguments[1])->hasKey($arguments[0], isset($arguments[2]) ? $arguments[2] : null);

		return $this;
	}
}
