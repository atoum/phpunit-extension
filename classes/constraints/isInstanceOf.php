<?php

namespace mageekguy\atoum\phpunit\constraints;

use PHPUnit;
use
	mageekguy\atoum\asserters,
	mageekguy\atoum\exceptions\logic,
	mageekguy\atoum\phpunit\constraint
;

class isInstanceOf extends constraint
{
	private $expected;

	public function __construct($expected, $description = null)
	{
		$this->expected = $expected;
		$this->description = $description;
	}

	protected function matches($actual)
	{
		$asserter = new asserters\phpObject();

		try
		{
			$asserter->setWith($actual)->isInstanceOf($this->expected);
		}
		catch (logic $exception)
		{
			throw new PHPUnit\Framework\Exception($exception->getMessage());
		}
	}
}
