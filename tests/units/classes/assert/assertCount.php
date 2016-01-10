<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertCount as testedClass
;

class assertCount extends \PHPUnit_Framework_TestCase
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
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Missing argument #1 (expectedCount) of mageekguy\\atoum\\phpunit\\assert\\assertCount', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(rand(0, PHP_INT_MAX)));

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Missing argument #2 (haystack) of mageekguy\\atoum\\phpunit\\assert\\assertCount', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid(), uniqid()));

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Argument #1 (expectedCount) of mageekguy\\atoum\\phpunit\\assert\\assertCount must be an integer', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(rand(0, PHP_INT_MAX), new \stdClass()));

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Argument #2 (haystack) of mageekguy\\atoum\\phpunit\\assert\\assertCount must be a string, an array, a countable object, a traversable object', $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array(5, 'atoum')));
		$this->assertSame($assert, $assert->setWithArguments(array(5, array('a', 't', 'o', 'u', 'm'))));
	}
}
