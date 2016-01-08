<?php

namespace mageekguy\atoum\phpunit;

use mageekguy\atoum;

abstract class test extends atoum\test
{
	public function setAssertionManager(atoum\test\assertion\manager $assertionManager = null)
	{
		$assertionManager = parent::setAssertionManager($assertionManager)->getAssertionManager();
		$self = $this;

		$assertionManager
			->setHandler('assertInstanceOf', function($class, $value, $failMessage = null) use ($self) {
				return $self->object($value)->isInstanceOf($class, $failMessage);
			})
		;

		return $this;
	}
}
