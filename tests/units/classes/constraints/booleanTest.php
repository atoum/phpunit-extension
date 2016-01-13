<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\boolean as testedClass
;

class boolean extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(true));
	}

	public function testThrowsExceptionIfExpectedCountIsNoBoolean()
	{
		$constraint = new testedClass(array());

		try
		{
			$constraint->evaluate(true);

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\boolean must be a boolean', $exception->getMessage());
		}
	}

	public function testFailsIfActualIsNoBoolean()
	{
		$constraint = new testedClass(true);
		$actual = array();

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not a boolean', $exception->getMessage());
		}
	}

	public function testFails()
	{
		$constraint = new testedClass(true);

		try
		{
			$constraint->evaluate(false);
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$diff = new atoum\tools\diff($analyzer->dump(true), $analyzer->dump(false));
			$this->assertEquals($analyzer->getTypeOf(false) . ' is not true' . PHP_EOL . $diff, $exception->getMessage());
		}

		$constraint = new testedClass(false);

		try
		{
			$constraint->evaluate(true);
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$diff = new atoum\tools\diff($analyzer->dump(false), $analyzer->dump(true));
			$this->assertEquals($analyzer->getTypeOf(true) . ' is not false' . PHP_EOL . $diff, $exception->getMessage());
		}
	}

	public function testPasses()
	{
		$constraint = new testedClass(true);
		$this->assertSame($constraint, $constraint->evaluate(true));

		$constraint = new testedClass(false);
		$this->assertSame($constraint, $constraint->evaluate(false));
	}
}
