<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer,
	mageekguy\atoum\asserter\exception
;

class greaterThanOrEqual extends greaterThan
{
	private $expected;

	public function __construct($expected, $description = null, analyzer $analyzer = null)
	{
		parent::__construct($expected, $description, $analyzer);

		$this->expected = $expected;
	}

	protected function matches($actual)
	{
		try
		{
			parent::matches($actual);
		}
		catch (exception $exception)
		{
			if (is_float($actual))
			{
				$asserter = new asserters\phpFloat();
			}
			else
			{
				$asserter = new asserters\integer();
			}


			$asserter->setWith($actual)->isGreaterThanOrEqualTo($this->expected);
		}
	}
}
