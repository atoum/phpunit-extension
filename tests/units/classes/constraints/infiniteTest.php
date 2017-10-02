<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\infinite as testedClass
;

class infinite extends \PHPUnit\Framework\TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
	}

	public function testAssertInfinite()
	{
		$constraint = new testedClass();
		$this->assertSame($constraint, $constraint->evaluate(INF));

		$actual = rand(0, PHP_INT_MAX);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not infinite', $exception->getMessage());
		}
	}
}
