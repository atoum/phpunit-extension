<?php

namespace mageekguy\atoum\phpunit;

use mageekguy\atoum;
use mageekguy\atoum\adapter;
use mageekguy\atoum\annotations;
use mageekguy\atoum\asserter;
use mageekguy\atoum\test\assertion;
use mageekguy\atoum\tools\variable\analyzer;
use PHPUnit;

abstract class test extends atoum\test
{
    const defaultMethodPrefix = '/^(test|should)|.*_should_/';
    const defaultEngine = 'inline';
    const defaultNamespace = '#(?:^|\\\)tests?\\\.*?units?.*?\\\#i';

    private $unsupportedMethods;

    public function __construct(adapter $adapter = null, annotations\extractor $annotationExtractor = null, asserter\generator $asserterGenerator = null, assertion\manager $assertionManager = null, \closure $reflectionClassFactory = null, \closure $phpExtensionFactory = null, analyzer $analyzer = null)
    {
        parent::__construct($adapter, $annotationExtractor, $asserterGenerator, $assertionManager, $reflectionClassFactory, $phpExtensionFactory, $analyzer);

        $this
            ->setDefaultEngine(static::defaultEngine);
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
            ->setHandler(
                'assertArrayHasKey',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\arrayHasKey($expected, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertArraySubset',
                function (array $expected, array $actual, $failMessage = null, $strict = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\arraySubset($expected, $failMessage, $strict, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertContainsOnly',
                function ($expected, $actual, $isNativeType = null, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\containsOnly($expected, $isNativeType, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertContainsOnlyInstancesOf',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\containsOnlyInstancesOf($expected, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertCount',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\count($expected, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertEmpty',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\isEmpty($failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertEquals',
                function ($expected, $actual, $failMessage = null, $delta = null, $maxDepth = null, $canonicalize = null, $ignoreCase = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\equals($expected, $failMessage, $delta, $maxDepth, $canonicalize, $ignoreCase, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertFalse',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\boolean(false, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertFinite',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\finite($failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertGreaterThan',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\greaterThan($expected, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertGreaterThanOrEqual',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\greaterThanOrEqual($expected, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'assertInfinite',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\infinite($failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertInstanceOf',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\isInstanceOf($expected, $failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertInternalType',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\internalType($expected, $failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertNaN',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\nan($failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertNotInstanceOf',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\isNotInstanceOf($expected, $failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertNotNull',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\isNotNull($failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertNotSame',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\notSame($expected, $failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertNull',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\isNull($failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertSame',
                function ($expected, $actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\same($expected, $failMessage));

                    return $test;
                }
            )
            ->setHandler(
                'assertTrue',
                function ($actual, $failMessage = null) use ($test) {
                    $test->assertThat($actual, new atoum\phpunit\constraints\boolean(true, $failMessage, $test->getAnalyzer()));

                    return $test;
                }
            )
            ->setHandler(
                'getMock',
                function () use ($test) {
                    $test->skip('getMock is not supported.');
                }
            )
            ->setHandler(
                'getMockForAbstractClass',
                function () use ($test) {
                    $test->skip('getMockForAbstractClass is not supported.');
                }
            )
            ->setHandler(
                'setExpectedException',
                function () use ($test) {
                    $test->skip('setExpectedException is not supported.');
                }
            )
        ;

        return $this;
    }

    public function getTestedClassName()
    {
        // atoum creates a default relation between a test suite and a class,
        // they are correlated. PHPUnit doesn't do that. If a test suite extends
        // `PHPUnit\Framework\TestCase`, then it is assumed that this relation
        // must be canceled, if a test suite extends `atoum\phpunit\test`,
        // then the relation is kept. The former is a child of the latter, so
        // it is easy to implement.
        //
        // The constant and function mock engines, and the code coverage
        // scores will not work.
        if ($this instanceof PHPUnit\Framework\TestCase) {
            return 'StdClass';
        }

        $testedClassName = parent::getTestedClassName();

        return preg_replace('/test$/i', '', $testedClassName);
    }

    public function getTestedClassNamespace()
    {
        // Please, refer to the comment of `self::getTestedClassName` to
        // understand this block.
        if ($this instanceof PHPUnit\Framework\TestCase) {
            return '\\';
        }

        return parent::getTestedClassNamespace();
    }

    public function markTestSkipped($message = null)
    {
        return $this->skip($message);
    }

    protected function setMethodAnnotations(annotations\extractor $extractor, & $methodName)
    {
        parent::setMethodAnnotations($extractor, $methodName);

        $test = $this;

        $tagHandler = function ($value) use ($test, & $methodName) {
            $test->setMethodTags($methodName, annotations\extractor::toArray($value));
        };

        $extractor
            ->setHandler('author', $tagHandler)
            ->setHandler(
                'expectedException',
                function ($value) use ($test, & $methodName) {
                    if ($value) {
                        $test->addUnsupportedMethod($methodName, '@expectedException is not supported.');
                    }
                }
            )
            ->setHandler('group', $tagHandler)
            ->setHandler('large', function () use ($tagHandler) {
                $tagHandler('large');
            })
            ->setHandler('medium', function () use ($tagHandler) {
                $tagHandler('medium');
            })
            ->setHandler('runInSeparateProcess', function () use ($test, & $methodName) {
                $test->setMethodEngine($methodName, 'isolate');
            })
            ->setHandler('small', function () use ($tagHandler) {
                $tagHandler('small');
            })
        ;

        return $this;
    }

    protected function setClassAnnotations(annotations\extractor $extractor)
    {
        parent::setClassAnnotations($extractor);

        $test = $this;

        $extractor
            ->setHandler('runTestsInSeparateProcesses', function () use ($test, & $methodName) {
                $test->setMethodEngine($methodName, 'isolate');
            })
        ;

        return $this;
    }


    public function addUnsupportedMethod($testMethod, $reason)
    {
        if (isset($this->unsupportedMethods[$testMethod]) === false) {
            $this->unsupportedMethods[$testMethod] = $reason;
        }

        return $this;
    }

    /**
     * The `setUp` method in atoum maps to the `setUpBeforeClass` method in
     * PHPUnit.
     */
    protected function callSetUp()
    {
        static::setUpBeforeClass();
    }

    /**
     * The `tearDown` method in atoum maps to the `tearDownAfterClass` method
     * in PHPUnit.
     */
    protected function callTearDown()
    {
        static::tearDownAfterClass();
    }

    /**
     * The `beforeTestMethod` method in atoum maps to the `setUp` method in
     * PHPUnit.
     */
    protected function callBeforeTestMethod($testMethod)
    {
        $this->beforeTestMethod($testMethod);
        $this->setUp();
    }

    /**
     * The `afterTestMethod` method in atoum maps to the `tearDown` method in
     * PHPUnit.
     */
    protected function callAfterTestMethod($testMethod)
    {
        $this->tearDown();
    }

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function beforeTestMethod($testMethod)
    {
        if (isset($this->unsupportedMethods[$testMethod])) {
            $this->markTestSkipped($this->unsupportedMethods[$testMethod]);
        } else {
            // Based on the comment in `self::getTestedClassName`, it is
            // required to re-adjust the mock engines for constants and
            // functions.
            $testedClassName = self::getTestedClassNameFromTestClass(
                $this->getClass(),
                $this->getTestNamespace()
            );
            $testedNamespace = substr(
                $testedClassName,
                0,
                strrpos($testedClassName, '\\')
            );

            $this->getPhpFunctionMocker()->setDefaultNamespace($testedNamespace);
            $this->getPhpConstantMocker()->setDefaultNamespace($testedNamespace);
        }
    }
}
