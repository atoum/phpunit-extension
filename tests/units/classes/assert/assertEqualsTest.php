<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertEquals as testedClass
;

class assertEquals extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\asserters\variable', new testedClass());
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
			$this->assertEquals('Missing argument #1 (expected) of mageekguy\\atoum\\phpunit\\assert\\assertEquals', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (actual) of mageekguy\\atoum\\phpunit\\assert\\assertEquals', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array($expected = uniqid(), $actual = uniqid()));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not equal to ' . $assert->getAnalyzer()->getTypeOf($expected) . PHP_EOL . $assert->getDiff()->setActual($actual)->setExpected($expected), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array($expected = uniqid(), $expected)));

		try
		{
			$assert->setWithArguments(array($expected = 1.0,  $actual = 1.1));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not equal to ' . $assert->getAnalyzer()->getTypeOf($expected) . PHP_EOL . $assert->getDiff()->setActual($actual)->setExpected($expected), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array($expected, $actual, null, 0.2)));

		try
		{
			$assert->setWithArguments(array($expected = 0, $actual = ''));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not an integer', $exception->getMessage());
		}
	}

	public function testSetWithArgumentsActualZero()
	{
		$this->markTestSkipped('Waiting for atoum/atoum#553 to be resolved');

		$assert = new testedClass();

		try
		{
			$assert->setWithArguments(array($expected = '', $actual = 0));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not an integer', $exception->getMessage());
		}
	}
}
