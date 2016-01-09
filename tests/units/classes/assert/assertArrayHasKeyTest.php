<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertArrayHasKey as testedClass
;

class assertArrayHasKey extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\asserters\phpArray', new testedClass());
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
			$this->assertEquals('Missing argument #1 (key) of mageekguy\\atoum\\phpunit\\assert\\assertArrayHasKey', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (array) of mageekguy\\atoum\\phpunit\\assert\\assertArrayHasKey', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid(), $actual = uniqid()));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not an array', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array($expected = uniqid(), $actual = array('foo' => 'bar')));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' has no key ' . $assert->getAnalyzer()->getTypeOf($expected), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('foo', $actual)));
	}
}
