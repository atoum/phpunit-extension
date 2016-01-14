<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\nan as testedClass
;

class nan extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
	}

	public function testAssertNan()
	{
		$constraint = new testedClass();
		$this->assertSame($constraint, $constraint->evaluate(NAN));

		$actual = rand(0, PHP_INT_MAX);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not NaN', $exception->getMessage());
		}
	}
}
