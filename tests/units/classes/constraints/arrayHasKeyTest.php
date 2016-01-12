<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\arrayHasKey as testedClass
;

require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/SampleArrayAccess.php';

class arrayHasKey extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(uniqid()));
	}

	public function testAssertArrayHasKeyThrowsExceptionForInvalidFirstArgument()
	{
		$constraint = new testedClass(null);

		try
		{
			$constraint->evaluate(array());

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\arrayHasKey must not be null', $exception->getMessage());
		}
	}

	public function testAssertArrayHasKeyThrowsExceptionForInvalidSecondArgument()
	{
		$constraint = new testedClass(0);

		try
		{
			$constraint->evaluate(null);

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\arrayHasKey must be an array or an arrayAccess instance', $exception->getMessage());
		}
	}

	public function testAssertArrayHasIntegerKey()
	{
		$actual = array(uniqid());

		$constraint = new testedClass(0);
		$constraint->evaluate($actual);

		$constraint = new testedClass(1);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$this->assertEquals('array(1) has no key integer(1)', $exception->getMessage());
		}
	}

	public function testAssertArrayHasStringKey()
	{
		$key = uniqid();
		$otherKey = uniqid();
		$actual = array($key => uniqid());

		$constraint = new testedClass($key);
		$constraint->evaluate($actual);

		$constraint = new testedClass($otherKey);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$this->assertEquals('array(1) has no key string(' . strlen($otherKey) . ') \'' . $otherKey . '\'', $exception->getMessage());
		}
	}

	public function testAssertArrayAccessHasStringKey()
	{
		$key = uniqid();
		$otherKey = uniqid();
		$actual = new \sampleArrayAccess();
		$actual[$key] = uniqid();

		$constraint = new testedClass($key);
		$constraint->evaluate($actual);

		$constraint = new testedClass($otherKey);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$this->assertEquals('object(SampleArrayAccess) has no key string(' . strlen($otherKey) . ') \'' . $otherKey . '\'', $exception->getMessage());
		}
	}
}
