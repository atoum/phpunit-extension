<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\internalType as testedClass;

class internalType extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(__CLASS__));
    }

    public function testAssertInternalType()
    {
        $constraint = new testedClass('integer');
        $this->assertSame($constraint, $constraint->evaluate(1));

        $actual = uniqid();

        try {
            $constraint->evaluate($actual);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals($analyzer->getTypeOf($actual) . ' is not an integer', $exception->getMessage());
        }
    }

    public function testAssertInternalTypeDouble()
    {
        $constraint = new testedClass('double');
        $this->assertSame($constraint, $constraint->evaluate(1.0));

        $actual = rand(0, PHP_INT_MAX);

        try {
            $constraint->evaluate($actual);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $diff = new atoum\tools\diffs\variable(true, false);
            $this->assertEquals($analyzer->getTypeOf($actual) . ' is not a double' . PHP_EOL . $diff, $exception->getMessage());
        }
    }

    public function testAssertInternalTypeThrowsExceptionForInvalidArgument()
    {
        $constraint = new testedClass(null);

        try {
            $constraint->evaluate(1);

            $this->fail();
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\internalType must be a valid type', $exception->getMessage());
        }
    }
}
