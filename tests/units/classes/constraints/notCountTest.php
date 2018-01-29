<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\notCount as testedClass;

class notCount extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(rand(0, PHP_INT_MAX)));
    }

    public function testAssertNotCount()
    {
        $constraint = new testedClass(2);
        $constraint->evaluate([1, 2, 3]);

        try {
            $constraint->evaluate([1, 2]);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('array(2) has size 2, expected different size', $exception->getMessage());
        }
    }

    public function testAssertNotCountTraversable()
    {
        $constraint = new testedClass(2);
        $constraint->evaluate(new \arrayIterator([1, 2, 3]));

        try {
            $constraint->evaluate(new \arrayIterator([1, 2]));

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('integer(2) is equal to integer(2)', $exception->getMessage());
        }
    }

    public function testAssertNotCountThrowsExceptionIfExpectedCountIsNoInteger()
    {
        $constraint = new testedClass('a');

        try {
            $constraint->evaluate([]);

            $this->fail();
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\notCount must be an integer', $exception->getMessage());
        }
    }

    public function testAssertNotCountThrowsExceptionIfElementIsNotCountable()
    {
        $constraint = new testedClass(2);

        try {
            $constraint->evaluate('');

            $this->fail();
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\notCount must be an array, a countable object or a traversable object', $exception->getMessage());
        }
    }
}
