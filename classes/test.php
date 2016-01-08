<?php

namespace mageekguy\atoum\phpunit;

use mageekguy\atoum;

abstract class test extends atoum\test
{
	const defaultTestedClass = '#Test$#';
	const defaultEngine = 'inline';

	public function setAsserterGenerator(atoum\test\asserter\generator $generator = null)
	{
		$generator = $generator ?: new atoum\test\asserter\generator($this);

		$generator
			->addNamespace(__NAMESPACE__ . '\\assert')
		;

		return parent::setAsserterGenerator($generator);
	}
}
