<?php

namespace mageekguy\atoum\phpunit;

use mageekguy\atoum;
use mageekguy\atoum\test\assertion;
use mageekguy\atoum\adapter;
use mageekguy\atoum\annotations;
use mageekguy\atoum\asserter;
use mageekguy\atoum\tools\variable\analyzer;

abstract class test extends atoum\test
{
	const defaultEngine = 'inline';

	public function __construct(adapter $adapter = null, annotations\extractor $annotationExtractor = null, asserter\generator $asserterGenerator = null, assertion\manager $assertionManager = null, \closure $reflectionClassFactory = null, \closure $phpExtensionFactory = null, analyzer $analyzer = null)
	{
		parent::__construct($adapter, $annotationExtractor, $asserterGenerator, $assertionManager, $reflectionClassFactory, $phpExtensionFactory, $analyzer);

		$this
			->setDefaultEngine(self::defaultEngine)
		;
	}

	public function setAsserterGenerator(atoum\test\asserter\generator $generator = null)
	{
		$generator = $generator ?: new atoum\test\asserter\generator($this);

		$generator
			->addNamespace(__NAMESPACE__ . '\\asserters')
		;

		return parent::setAsserterGenerator($generator);
	}

	public function setAssertionManager(assertion\manager $assertionManager = null)
	{
		parent::setAssertionManager($assertionManager);

		$test = $this;

		$this->getAssertionManager()
			->setHandler('assertArrayHasKey', function($expected, $actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\arrayHasKey($expected, $failMessage));

					return $test;
				}
			)
			->setHandler('assertArraySubset', function(array $expected, array $actual, $failMessage = null, $strict = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\arraySubset($expected, $failMessage, $strict));

					return $test;
				}
			)
			->setHandler('assertContainsOnly', function($expected, $actual, $isNativeType = null, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\containsOnly($expected, $isNativeType, $failMessage));

					return $test;
				}
			)
			->setHandler('assertContainsOnlyInstancesOf', function($expected, $actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\containsOnlyInstancesOf($expected, $failMessage));

					return $test;
				}
			)
			->setHandler('assertCount', function($expected, $actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\count($expected, $failMessage));

					return $test;
				}
			)
			->setHandler('assertEmpty', function($actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\isEmpty($failMessage));

					return $test;
				}
			)
			->setHandler('assertEquals', function($expected, $actual, $failMessage = null, $delta = null, $maxDepth = null, $canonicalize = null, $ignoreCase = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\equals($expected, $failMessage, $delta, $maxDepth, $canonicalize, $ignoreCase));

					return $test;
				}
			)
			->setHandler('assertFalse', function($actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\boolean(false, $failMessage));

					return $test;
				}
			)
			->setHandler('assertInstanceOf', function($expected, $actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\isInstanceOf($expected, $failMessage));

					return $test;
				}
			)
			->setHandler('assertNotNull', function($actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\isNotNull($failMessage));

					return $test;
				}
			)
			->setHandler('assertNull', function($actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\isNull($failMessage));

					return $test;
				}
			)
			->setHandler('assertSame', function($expected, $actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\same($expected, $failMessage));

					return $test;
				}
			)
			->setHandler('assertTrue', function($actual, $failMessage = null) use ($test) {
					$test->assertThat($actual, new atoum\phpunit\constraints\boolean(true, $failMessage));

					return $test;
				}
			)
		;

		return $this;
	}

	public function markTestSkipped($message = null)
	{
		return $this->skip($message);
	}
}
