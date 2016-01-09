<?php

namespace mageekguy\atoum\phpunit\tests\units\assert;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\assert\assertContains as testedClass
;

class assertContains extends \PHPUnit_Framework_TestCase
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
			$this->assertEquals('Missing argument #1 (needle) of mageekguy\\atoum\\phpunit\\assert\\assertContains', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(uniqid()));

			$this->fail();
		}
		catch (atoum\exceptions\runtime $exception)
		{
			$this->assertEquals('Missing argument #2 (haystack) of mageekguy\\atoum\\phpunit\\assert\\assertContains', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array($needle = 4, $haystack = array(1, 2, 3)));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack) . ' does not contain ' . $assert->getAnalyzer()->getTypeOf($needle), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array(3, array(1, 2, 3))));

		try
		{
			$assert->setWithArguments(array($needle = 4, $haystack = new \arrayIterator(array(1, 2, 3))));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf(iterator_to_array($haystack)) . ' does not contain ' . $assert->getAnalyzer()->getTypeOf($needle), $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array(3, new \arrayIterator(array(1, 2, 3)))));

		try
		{
			$assert->setWithArguments(array($needle = 'baz', $haystack = 'foobar'));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack) . ' does not contain ' . $needle, $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('bar', 'foobar')));

		try
		{
			$assert->setWithArguments(array($needle = 'bar', $haystack = 'fooBar'));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack) . ' does not contain ' . $needle, $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('bar', 'fooBar', null, true)));

		try
		{
			$assert->setWithArguments(array($needle = 'Bar', $haystack = 'foobar'));

			$this->fail();
		}
		catch (atoum\asserter\exception $exception)
		{
			$this->assertEquals($assert->getAnalyzer()->getTypeOf($haystack) . ' does not contain ' . $needle, $exception->getMessage());
		}

		$this->assertSame($assert, $assert->setWithArguments(array('Bar', 'foobar', null, true)));
	}
}
