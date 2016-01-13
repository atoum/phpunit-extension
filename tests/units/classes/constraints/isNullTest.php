<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\isNull as testedClass
;

class isNull extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
	}

	/**
	 * @dataProvider notNullProvider
	 */
	public function testFails($actual)
	{
		$constraint = new testedClass();

		try
		{
			$constraint->evaluate($actual);
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$analyzer = new atoum\tools\variable\analyzer();

			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not null', $exception->getMessage());
		}
	}

	public function testPasses()
	{
		$constraint = new testedClass();
		$this->assertSame($constraint, $constraint->evaluate(null));
	}

	public function notNullProvider()
	{
		return array(
			array(''),
			array(0),
			array(false),
			array(uniqid())
		);
	}
}
