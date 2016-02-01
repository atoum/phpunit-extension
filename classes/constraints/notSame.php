<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint
;

class notSame extends constraint
{
	private $expected;

	public function __construct($expected, $description = null)
	{
		$this->expected = $expected;
		$this->description = $description;
	}

	protected function matches($actual)
	{
		$asserter = new asserters\variable();
		$asserter->setWith($actual)->isNotIdenticalTo($this->expected);
	}
}
