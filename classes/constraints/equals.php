<?php

namespace mageekguy\atoum\phpunit\constraints;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer
;

class equals extends constraint
{
	private $expected;
	private $delta;
	private $maxDepth;
	private $canonicalize;
	private $ignoreCase;
	private $analyzer;

	public function __construct($expected, $description = null, $delta = null, $maxDepth = null, $canonicalize = null, $ignoreCase = null, analyzer $analyzer = null)
	{
		$this->expected = $expected;
		$this->description = $description;
		$this->delta = $delta;
		$this->maxDepth = $maxDepth ?: 10;
		$this->canonicalize = (bool) $canonicalize;
		$this->ignoreCase = (bool) $ignoreCase;
		$this->analyzer = $analyzer ?: new analyzer();
	}

	protected function matches($actual)
	{
		if ($this->delta == null && $this->analyzer->isFloat($actual) === false && $this->analyzer->isFloat($this->expected) === false)
		{
			$asserter = new asserters\variable(null, $this->analyzer);

			if ($this->analyzer->isString($actual) && $this->ignoreCase)
			{
				$actual = strtolower($actual);
			}

			if ($this->analyzer->isArray($actual) && $this->canonicalize)
			{
				$actual = sort($actual);
			}

			$asserter->setWith($actual);

			if (($actual === 0 && $this->expected == '') || ($actual == '' && $this->expected === 0))
			{
				$asserter->isIdenticalTo($this->expected);
			}
			else
			{
				$expected = $this->expected;

				if ($this->analyzer->isString($expected) && $this->ignoreCase)
				{
					$expected = strtolower($expected);
				}

				if ($this->analyzer->isArray($expected) && $this->canonicalize)
				{
					$expected = sort($expected);
				}

				$asserter->isEqualTo($expected);
			}
		}
		else
		{
			$asserter = new asserters\phpFloat(null, $this->analyzer);
			$asserter->setWith((float) $actual)->isNearlyEqualTo((float) $this->expected, $this->delta);
		}
	}
}
