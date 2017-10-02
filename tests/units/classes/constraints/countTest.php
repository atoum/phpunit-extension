<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\count as testedClass
;

class count extends \PHPUnit\Framework\TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(rand(0, PHP_INT_MAX)));
	}

	public function testAssertCount()
	{
		$constraint = new testedClass(2);
		$constraint->evaluate(array(1, 2));

		try
		{
			$constraint->evaluate(array(1, 2, 3));

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$this->assertEquals('array(3) has size 3, expected size 2', $exception->getMessage());
		}
	}

	public function testAssertCountTraversable()
	{
		$constraint = new testedClass(2);
		$constraint->evaluate(new \arrayIterator(array(1, 2)));

		try
		{
			$constraint->evaluate(new \arrayIterator(array(1, 2, 3)));

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$diff = new atoum\tools\diff($analyzer->dump(2), $analyzer->dump(3));
			$this->assertEquals('integer(3) is not equal to integer(2)' . PHP_EOL . $diff, $exception->getMessage());
		}
	}

	public function testAssertCountThrowsExceptionIfExpectedCountIsNoInteger()
	{
		$constraint = new testedClass('a');

		try
		{
			$constraint->evaluate(array());

			$this->fail();
		}
		catch (\PHPUnit\Framework\Exception $exception)
		{
			$this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\count must be an integer', $exception->getMessage());
		}
	}

	public function testAssertCountThrowsExceptionIfElementIsNotCountable()
	{
		$constraint = new testedClass(2);

		try
		{
			$constraint->evaluate('');

			$this->fail();
		}
		catch (\PHPUnit\Framework\Exception $exception)
		{
			$this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\count must be an array, a countable object or a traversable object', $exception->getMessage());
		}
	}
}
