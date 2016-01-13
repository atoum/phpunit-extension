<?php

namespace mageekguy\atoum\phpunit\asserters;

use
	mageekguy\atoum\asserter,
	mageekguy\atoum\exceptions\logic,
	mageekguy\atoum\phpunit\constraint
;

class assertThat extends asserter
{
	public function setWithArguments(array $arguments)
	{
		$actual = $arguments[0];
		$constraint = $arguments[1];
		$failMessage = isset($arguments[2]) ? $arguments[2] : null;

		if ($constraint instanceof constraint === false)
		{
			throw new logic('Argument #2 of ' . __CLASS__ . ' must be an instance of mageekguy\\atoum\\phpunit\\assert\\constraint');
		}

		try
		{
			$constraint->evaluate($actual, $failMessage);

			$this->pass();
		}
		catch (constraint\exception $exception)
		{
			$this->fail($exception->getMessage());
		}

		return $this;
	}
}
