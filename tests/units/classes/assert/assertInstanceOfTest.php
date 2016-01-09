<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertInstanceOf as testedClass
;

class assertInstanceOf extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\asserters\object', new testedClass());
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
			$this->assertEquals('Missing argument #1 (expected) of mageekguy\\atoum\\phpunit\\assert\\assertInstanceOf', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (actual) of mageekguy\\atoum\\phpunit\\assert\\assertInstanceOf', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid(), $actual = uniqid()));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not an object', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid(), new \stdClass()));

			$this->fail();
		}
		catch (atoum\exceptions\logic $exception)
		{
			$this->assertEquals('Argument of mageekguy\atoum\asserters\object::isInstanceOf() must be a class instance or a class name', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(__CLASS__, $actual = new \stdClass()));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' is not an instance of ' . __CLASS__, $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('stdClass', new \stdClass())));
	}
}
