<?php

namespace mageekguy\atoum\phpunit\constraints;

use PHPUnit;
use
	mageekguy\atoum\asserter\exception,
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer
;

class arrayHasKey extends constraint
{
	private $analyzer;
	private $expected;

	public function __construct($expected, $description = null, analyzer $analyzer = null)
	{
		$this->analyzer = $analyzer ?: new analyzer();
		$this->expected = $expected;
		$this->description = $description;
	}

	protected function matches($actual)
	{
		if (is_null($this->expected))
		{
			throw new PHPUnit\Framework\Exception('Expected value of ' . __CLASS__ . ' must not be null');
		}

		if ($this->analyzer->isArray($actual) === false && $actual instanceof \arrayAccess === false)
		{
			throw new PHPUnit\Framework\Exception('Actual value of ' . __CLASS__ . ' must be an array or an arrayAccess instance');
		}

		if ($this->analyzer->isArray($actual))
		{
			$asserter = new asserters\phpArray(null, $this->analyzer);
			$asserter->setWith($actual)->hasKey($this->expected);
		}
		else
		{
			$asserter = new asserters\boolean(null, $this->analyzer);

			try
			{
				$asserter->setWith(isset($actual[$this->expected]))->isTrue();
			}
			catch (exception $exception)
			{
				throw new exception($asserter, $this->analyzer->getTypeOf($actual) . ' has no key ' . $this->analyzer->getTypeOf($this->expected));
			}
		}
	}
}
