<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\exceptions\logic,
	mageekguy\atoum\phpunit\constraint
;

class isNotInstanceOf extends constraint
{
	private $expected;

	public function __construct($expected, $description = null)
	{
		$this->expected = $expected;
		$this->description = $description;
	}

	protected function matches($actual)
	{
		$asserter = new asserters\object();

		try
		{
			$asserter->setWith($actual)->isNotInstanceOf($this->expected);
		}
		catch (logic $exception)
		{
			throw new \PHPUnit_Framework_Exception($exception->getMessage());
		}
	}
}
