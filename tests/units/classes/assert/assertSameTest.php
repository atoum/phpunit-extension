<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertSame as testedClass
;

class assertSame extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\asserter', new testedClass());
	}

	public function testSetWithArguments()
	{
		$assert = new testedClass();

		try
		{
			$assert->setWithArguments(array());

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #1 (expected) of mageekguy\\atoum\\phpunit\\assert\\assertSame', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (actual) of mageekguy\\atoum\\phpunit\\assert\\assertSame', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array($expected = new \stdClass, $actual = new \stdClass));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not identical to ' . $assert->getAnalyzer()->getTypeOf($expected) . PHP_EOL . $assert->getDiff()->setActual($actual)->setExpected($expected), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array($expected = new \stdClass, $expected)));
	}
}
