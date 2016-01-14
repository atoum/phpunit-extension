<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer,
	mageekguy\atoum\asserter\exception
;

class infinite extends constraint
{
	private $analyzer;

	public function __construct($description = null, analyzer $analyzer = null)
	{
		$this->description = $description;
		$this->analyzer = $analyzer ?: new analyzer();
	}

	protected function matches($actual)
	{
		$asserter = new asserters\boolean();

		try
		{
			$asserter->setWith(is_infinite($actual))->isTrue();
		}
		catch (exception $exception)
		{
			throw new exception($asserter, $this->analyzer->getTypeOf($actual) . ' is not infinite');
		}

	}
}
