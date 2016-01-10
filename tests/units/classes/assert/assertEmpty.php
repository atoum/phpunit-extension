<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertEmpty as testedClass
;

class assertEmpty extends \PHPUnit_Framework_TestCase
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
			$this->assertEquals('Missing argument #1 (actual) of mageekguy\\atoum\\phpunit\\assert\\assertEmpty', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(new \stdClass()));

			$this->fail();
		}
		catch (\PHPUnit_Framework_Exception $exception)
		{
			$this->assertEquals('Argument #1 (actual) of mageekguy\\atoum\\phpunit\\assert\\assertEmpty must be a string, an array, a countable object, a traversable object', $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('')));
		$this->assertSame($assert, $assert->setWithArguments(array(array())));
		$this->assertSame($assert, $assert->setWithArguments(array(new \arrayIterator(array()))));
	}
}
