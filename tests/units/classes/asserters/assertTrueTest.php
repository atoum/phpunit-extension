<?php

namespace mageekguy\atoum\phpunit\tests\units\asserters;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\asserters\assertTrue as testedClass
;

class assertTrue extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\asserters\boolean', new testedClass());
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
			$this->assertEquals('Missing argument #1 (actual) of mageekguy\\atoum\\phpunit\\asserters\\assertTrue', $exception->getMessage());
		}

		$actual = rand(0, PHP_INT_MAX);
		$analyzer = new atoum\tools\variable\analyzer();

		try
		{
			$assert->setWithArguments(array($actual));

			$this->fail();
		}
		catch (\PHPUnit_Framework_AssertionFailedError $exception)
		{

			$this->assertEquals($analyzer->getTypeOf($actual) . ' is not a boolean', $exception->getMessage());
		}

		try
		{
			$assert->setWithArguments(array(false));

			$this->fail();
		}
		catch (\PHPUnit_Framework_AssertionFailedError $exception)
		{
			$diff = new atoum\tools\diff($analyzer->dump(true), $analyzer->dump(false));
			$this->assertEquals($analyzer->getTypeOf(false) . ' is not true' . PHP_EOL . $diff, $exception->getMessage());
		}
	}
}
