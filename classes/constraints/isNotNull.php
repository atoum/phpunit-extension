<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint
;

class isNotNull extends constraint
{
	public function __construct($description = null)
	{
		$this->description = $description;
	}

	protected function matches($actual)
	{
		$asserter = new asserters\variable();
		$asserter->setWith($actual)->isNotNull();
	}
}
