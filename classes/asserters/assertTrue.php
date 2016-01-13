<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class assertTrue extends atoum\asserters\boolean
{
	public function setWithArguments(array $arguments)
	{
		if (isset($arguments[0]) === false)
		{
			throw new \PHPUnit_Framework_Exception('Missing argument #1 (actual) of ' . __CLASS__);
		}

		try
		{
			parent::setWithArguments($arguments)->isTrue(isset($arguments[1]) ? $arguments[1] : null);
		}
		catch (atoum\asserter\exception $exception)
		{
			throw new \PHPUnit_Framework_AssertionFailedError($exception->getMessage());
		}

		return $this;
	}
}
