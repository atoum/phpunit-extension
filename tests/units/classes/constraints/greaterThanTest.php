<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\greaterThan as testedClass
;

class greaterThan extends \PHPUnit\Framework\TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(rand(0, PHP_INT_MAX)));
	}

	public function testGreaterThanWithIntegers()
	{
		$expected = 1;
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(2));

		$actual = 1;

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not greater than ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testGreaterThanWithFloats()
	{
		$expected = 1;
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(4 / 3));

		$actual = 1 / 3;

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not greater than ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}
}
