<?php

namespace mageekguy\atoum\phpunit\constraints;

use PHPUnit;
use
	mageekguy\atoum\asserters,
	mageekguy\atoum\phpunit\constraint,
	mageekguy\atoum\tools\variable\analyzer;

class count extends constraint
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
		if ($this->analyzer->isInteger($this->expected) === false)
		{
			throw new PHPUnit\Framework\Exception('Expected value of ' . __CLASS__ . ' must be an integer');
		}

		switch (true)
		{
			case $this->analyzer->isArray($actual):
				$asserter = new asserters\phpArray(null, $this->analyzer);
				$asserter->setWith($actual)->hasSize($this->expected);
				break;

			case $actual instanceof \countable:
				$asserter = new asserters\sizeOf(null, $this->analyzer);
				$asserter->setWith($actual)->isEqualTo($this->expected);
				break;

			case $actual instanceof \iteratorAggregate:
				$asserter = new asserters\integer(null, $this->analyzer);
				$asserter->setWith(iterator_count($actual->getIterator()))->isEqualTo($this->expected);
				break;

			case $actual instanceof \traversable:
			case $actual instanceof \iterator:
				$asserter = new asserters\integer(null, $this->analyzer);
				$asserter->setWith(iterator_count($actual))->isEqualTo($this->expected);
				break;

			default:
				throw new PHPUnit\Framework\Exception('Actual value of ' . __CLASS__ . ' must be an array, a countable object or a traversable object');
		}
	}
}
