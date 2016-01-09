<?php

namespace mageekguy\atoum\phpunit;

use mageekguy\atoum;
use mageekguy\atoum\adapter;
use mageekguy\atoum\annotations;
use mageekguy\atoum\asserter;
use mageekguy\atoum\tools\variable\analyzer;

abstract class test extends atoum\test
{
	//const defaultNamespace = '#(?:^|\\\)(?:Tests?\\\)?#i';
	//const defaultTestedClass = '#Test$#';
	const defaultEngine = 'inline';

	public function __construct(adapter $adapter = null, annotations\extractor $annotationExtractor = null, asserter\generator $asserterGenerator = null, \mageekguy\atoum\test\assertion\manager $assertionManager = null, \closure $reflectionClassFactory = null, \closure $phpExtensionFactory = null, analyzer $analyzer = null)
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
			->addNamespace(__NAMESPACE__ . '\\assert')
		;

		return parent::setAsserterGenerator($generator);
	}

	public function markTestSkipped($message = null)
	{
		return $this->skip($message);
	}
}
