<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\isEmpty as testedClass;

class isEmpty extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
    }

    public function testAssertStringIsEmpty()
    {
        $constraint = new testedClass();
        $constraint->evaluate('');

        try {
            $constraint->evaluate('foo');

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('string(3) \'foo\' is not empty', $exception->getMessage());
        }
    }

    public function testAssertArrayIsEmpty()
    {
        $constraint = new testedClass();
        $constraint->evaluate([]);

        try {
            $constraint->evaluate([1, 2]);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('array(2) is not empty', $exception->getMessage());
        }
    }
}
