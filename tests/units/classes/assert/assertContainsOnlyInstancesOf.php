<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertContainsOnlyInstancesOf as testedClass
;

class assertContainsOnlyInstancesOf extends \PHPUnit_Framework_TestCase
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
			$this->assertEquals('Missing argument #1 (type) of mageekguy\\atoum\\phpunit\\assert\\assertContainsOnlyInstancesOf', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (haystack) of mageekguy\\atoum\\phpunit\\assert\\assertContainsOnlyInstancesOf', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(4, array(1, 2, 3)));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Argument #1 (type) of mageekguy\\atoum\\phpunit\\assert\\assertContainsOnlyInstancesOf must be a string', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array('integer', $haystack = array(1, 2, 3)));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack[0]) . ' is not an object', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array('integer', $haystack = array(new \stdClass)));

			$this->fail();
		}
		catch (atoum\exceptions\logic $exception)
		{
			$this->assertEquals('Argument of mageekguy\atoum\asserters\object::isInstanceOf() must be a class instance or a class name', $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('stdClass', array(new \stdClass))));
		$this->assertSame($assert, $assert->setWithArguments(array('stdClass', new \arrayIterator(array(new \stdClass)))));
	}
}
