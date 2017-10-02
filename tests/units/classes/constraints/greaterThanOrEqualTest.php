<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\greaterThanOrEqual as testedClass
;

class greaterThanOrEqual extends \PHPUnit\Framework\TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraints\greaterThan', new testedClass(rand(0, PHP_INT_MAX)));
	}

	public function testGreaterThanOrEqualWithIntegers()
	{
		$expected = 1;
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(1));
		$this->assertSame($constraint, $constraint->evaluate(2));

		$actual = 0;

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not greater than or equal to ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testGreaterThanOrEqualWithFloats()
	{
		$expected = 1;
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate((float) $expected));
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
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not greater than or equal to ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}
}
