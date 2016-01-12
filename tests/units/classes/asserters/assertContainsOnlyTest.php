<?php

namespace mageekguy\atoum\phpunit\tests\units\asserters;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\asserters\assertContainsOnly as testedClass
;

class assertContainsOnly extends \PHPUnit_Framework_TestCase
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
			$this->assertEquals('Missing argument #1 (type) of mageekguy\\atoum\\phpunit\\asserters\\assertContainsOnly', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (haystack) of mageekguy\\atoum\\phpunit\\asserters\\assertContainsOnly', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(4, array(1, 2, 3)));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Argument #1 (type) of mageekguy\\atoum\\phpunit\\asserters\\assertContainsOnly must be a string', $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('integer', array(1, 2, 3))));

		try
		{
			$assert->setWithArguments(array($type = 'string', $haystack = array('1', '2', 3)));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack[2]) . ' is not a ' . $type, $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('integer', new \arrayIterator(array(1, 2, 3)))));

		try
		{
			$assert->setWithArguments(array($type = 'stdClass', $haystack = array(new \stdClass(), new \stdClass(), 3), false));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack[2]) . ' is not an object', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array($type = 'stdClass', $haystack = array(new \stdClass(), new \stdClass(), new \arrayIterator(array())), false));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack[2]) . ' is not an instance of stdClass', $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('stdClass', new \arrayIterator(array(new \stdClass(), new \stdClass(), new \stdClass())), false)));
	}
}
