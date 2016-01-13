<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer
;

class boolean extends constraint
{
	private $expected;
	private $analyzer;

	public function __construct($expected, $description = null, analyzer $analyzer = null)
	{
		$this->analyzer = $analyzer ?: new analyzer();
		$this->expected = $expected;
		$this->description = $description;
	}

	protected function matches($actual)
	{
		if ($this->analyzer->isBoolean($this->expected) === false)
		{
			throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must be a boolean');
		}

		$asserter = new asserters\boolean(null, $this->analyzer);
		$asserter->setWith($actual);

		if ($this->expected)
		{
			$asserter->isTrue();
		}
		else
		{
			$asserter->isFalse();
		}
	}
}
