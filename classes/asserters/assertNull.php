<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class assertNull extends atoum\asserters\variable
{
	public function setWithArguments(array $arguments)
	{
		if (array_key_exists(0, $arguments) === false)
		{
			throw new \PHPUnit_Framework_Exception('Missing argument #1 (actual) of ' . __CLASS__);
		}

		try
		{
			parent::setWithArguments($arguments)->isNull(isset($arguments[1]) ? $arguments[1] : null);
		}
		catch (atoum\asserter\exception $exception)
		{
			throw new \PHPUnit_Framework_AssertionFailedError($exception->getMessage());
		}

		return $this;
	}
}
