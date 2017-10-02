<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\containsOnly as testedClass;

require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/SampleArrayAccess.php';

class containsOnly extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(__CLASS__));
    }

    public function testAssertContainsOnlyThrowsException()
    {
        $constraint = new testedClass(null);

        try {
            $constraint->evaluate([rand(0, PHP_INT_MAX)]);
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\containsOnly must be a valid type or class name', $exception->getMessage());
        }

        $constraint = new testedClass(uniqid());

        try {
            $constraint->evaluate([rand(0, PHP_INT_MAX)]);
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\containsOnly must be a valid type or class name', $exception->getMessage());
        }

        $constraint = new testedClass('integer');

        try {
            $constraint->evaluate(null);
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\containsOnly must be an array or a traversable object', $exception->getMessage());
        }
    }

    public function testAssertArrayContainsOnlyIntegers()
    {
        $constraint = new testedClass('integer');
        $this->assertSame($constraint, $constraint->evaluate([1, 2, 3]));

        $actual = ['1', 2, 3];

        try {
            $constraint->evaluate($actual);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals($analyzer->getTypeOf($actual[0]) . ' is not an integer', $exception->getMessage());
        }
    }

    public function testAssertArrayContainsOnlyStdClass()
    {
        $constraint = new testedClass('StdClass');
        $this->assertSame($constraint, $constraint->evaluate([new \stdClass()]));

        $actual = ['StdClass'];

        try {
            $constraint->evaluate($actual);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals($analyzer->getTypeOf($actual[0]) . ' is not an object', $exception->getMessage());
        }
    }
}
