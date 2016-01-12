<?php

namespace mageekguy\atoum\phpunit\tests\units\asserters;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\asserters\assertArraySubset as testedClass
;

class assertArraySubset extends \PHPUnit_Framework_TestCase
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
			$this->assertEquals('Missing argument #1 (subset) of mageekguy\\atoum\\phpunit\\asserters\\assertArraySubset', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (array) of mageekguy\\atoum\\phpunit\\asserters\\assertArraySubset', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid(), uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Argument #1 (subset) of mageekguy\\atoum\\phpunit\\asserters\\assertArraySubset must be an array', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array($expected = array('config' => array('key-a', 'key-b')), $actual = array('config' => array('key-a'))));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($actual) . ' does not contain ' . $assert->getAnalyzer()->getTypeOf($expected['config']), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array($expected, $expected)));
	}
}
