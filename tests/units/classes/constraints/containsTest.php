<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\contains as testedClass
;

require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/TestIterator.php';

class contains extends \PHPUnit\Framework\TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(uniqid()));
	}

	public function testAssertSplObjectStorageContainsObject()
	{
		$expected = new \stdClass();
		$b = new \stdClass();
		$actual = new \splObjectStorage();
		$actual->attach($expected);

		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate($actual));

		$constraint = new testedClass($b);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testAssertArrayContainsObject()
	{
		$expected = new \stdClass();
		$b = new \stdClass();

		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(array($expected)));

		$actual = array($b);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testAssertArrayContainsString()
	{
		$expected = 'foo';
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(array('foo')));

		$actual = array('bar');

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testAssertArrayContainsNonObject()
	{
		$expected = 'foo';
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate('foo'));

		$constraint = new testedClass($expected, null, false, true, true);
		$actual = array(true);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testAssertContainsThrowsException()
	{
		$constraint = new testedClass(null);

		try
		{
			$constraint->evaluate(null);
		}
		catch (\PHPUnit\Framework\Exception $exception)
		{
			$this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\contains must be an array, a string or a traversable object', $exception->getMessage());
		}
	}

	public function testAssertIteratorContainsObject()
	{
		$expected = new \stdClass();
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(array($expected)));

		$actual = new \testIterator(array(new \stdClass()));

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testAssertIteratorContainsString()
	{
		$expected = 'foo';
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate(new \testIterator(array($expected))));

		$actual = new \testIterator(array('bar'));

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}

	public function testAssertStringContainsString()
	{
		$expected = 'foo';
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate('foobar'));

		$actual = 'bar';

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit\Framework\ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();
			$this->assertEquals($analyzer->getTypeOf($actual) . ' does not contain ' . $analyzer->getTypeOf($expected), $exception->getMessage());
		}
	}
}
