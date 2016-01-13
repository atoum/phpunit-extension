<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\arraySubset as testedClass
;

class arraySubset extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(array()));
	}

	public function testAssertArraySubset()
	{
		$array = array(
			'a' => 'item a',
			'b' => 'item b',
			'c' => array('a2' => 'item a2', 'b2' => 'item b2'),
			'd' => array('a2' => array('a3' => 'item a3', 'b3' => 'item b3'))
		);

		$constraint = new testedClass(array('a' => 'item a', 'c' => array('a2' => 'item a2')));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$constraint = new testedClass(array('a' => 'item a', 'd' => array('a2' => array('b3' => 'item b3'))));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$expected = array('a' => 'bad value');
		$constraint = new testedClass($expected);

		$analyzer = new atoum\tools\variable\analyzer();

		try
		{
			$constraint->evaluate($array);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$patched = array_replace_recursive($array, $expected);
			$diff = new atoum\tools\diffs\variable($patched, $array);
			$this->assertEquals($analyzer->getTypeOf($array) . ' is not equal to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
		}

		$expected = array('d' => array('a2' => array('bad index' => 'item b3')));
		$constraint = new testedClass($expected);

		try
		{
			$constraint->evaluate($array);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$patched = array_replace_recursive($array, $expected);
			$diff = new atoum\tools\diffs\variable($patched, $array);
			$this->assertEquals($analyzer->getTypeOf($array) . ' is not equal to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
		}
	}

	public function testAssertArraySubsetWithDeepNestedArrays()
	{
		$array = array(
			'path' => array(
				'to' => array(
					'the' => array(
						'cake' => 'is a lie'
					)
				)
			)
		);

		$constraint = new testedClass(array('path' => array()));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$constraint = new testedClass(array('path' => array('to' => array())));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$constraint = new testedClass(array('path' => array('to' => array('the' => array()))));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$constraint = new testedClass(array('path' => array('to' => array('the' => array('cake' => 'is a lie')))));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$expected = array('path' => array('to' => array('the' => array('cake' => 'is not a lie'))));
		$constraint = new testedClass($expected);
		$analyzer = new atoum\tools\variable\analyzer();

		try
		{
			$constraint->evaluate($array);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$patched = array_replace_recursive($array, $expected);
			$diff = new atoum\tools\diffs\variable($patched, $array);
			$this->assertEquals($analyzer->getTypeOf($array) . ' is not equal to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
		}
	}

	public function testAssertArraySubsetWithNoStrictCheckAndObjects()
	{
		$obj = new \stdClass;
		$reference = &$obj;
		$array = array('a' => $obj);

		$constraint = new testedClass(array('a' => $reference));
		$this->assertSame($constraint, $constraint->evaluate($array));

		$constraint = new testedClass(array('a' => new \stdClass));
		$this->assertSame($constraint, $constraint->evaluate($array));
	}

	public function testAssertArraySubsetWithStrictCheckAndObjects()
	{
		$obj       = new \stdClass;
		$reference = &$obj;
		$array     = array('a' => $obj);

		$constraint = new testedClass(array('a' => $reference), null, true);
		$this->assertSame($constraint, $constraint->evaluate($array));

		$expected = array('a' => new \stdClass);
		$constraint = new testedClass($expected, null, true);
		$analyzer = new atoum\tools\variable\analyzer();

		try
		{
			$constraint->evaluate($array);

			$this->fail('Strict recursive array check fail.');
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$patched = array_replace_recursive($array, $expected);
			$diff = new atoum\tools\diffs\variable($patched, $array);
			$this->assertEquals($analyzer->getTypeOf($array) . ' is not identical to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
		}
	}

	/**
	 * @dataProvider assertArraySubsetInvalidArgumentProvider
	 */
	public function testAssertArraySubsetRaisesExceptionForInvalidArguments($expected, $actual)
	{
		$constraint = new testedClass($expected);
		$analyzer = new atoum\tools\variable\analyzer();

		try
		{
			$this->assertSame($constraint, $constraint->evaluate($actual));

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\arraySubset must be an array', $exception->getMessage());
		}
	}

	public function assertArraySubsetInvalidArgumentProvider()
	{
		return array(
			//array(false, array()),
			array(array(), false),
		);
	}
}
