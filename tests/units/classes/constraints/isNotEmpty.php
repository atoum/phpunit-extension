<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\isNotEmpty as testedClass;

class isNotEmpty extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraints\notCount', new testedClass());
    }

    public function testAssertStringIsNotEmpty()
    {
        $constraint = new testedClass();
        $constraint->evaluate('foo');

        try {
            $constraint->evaluate('');

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('string is empty', $exception->getMessage());
        }
    }

    public function testAssertArrayIsNotEmpty()
    {
        $constraint = new testedClass();
        $constraint->evaluate([1, 2]);

        try {
            $constraint->evaluate([]);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('array(0) has size 0, expected different size', $exception->getMessage());
        }
    }
}
