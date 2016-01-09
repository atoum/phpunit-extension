<?php

namespace mageekguy\atoum\phpunit\assert;

use mageekguy\atoum;

class assertEquals extends atoum\asserters\variable
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

		if (sizeof($arguments) < 4)
		{
			if ($arguments[1] !== 0 && $arguments[0] !== 0)
			{
				$this->setWith($arguments[1])->isEqualTo($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
			}
			else
			{
				$this->integer($arguments[1])->isEqualTo($arguments[0], isset($arguments[2]) ? $arguments[2] : null);
			}
		}
		else
		{
			$this->float($arguments[1])->isNearlyEqualTo($arguments[0], $arguments[3], $arguments[2]);
		}

		return $this;
	}
}
