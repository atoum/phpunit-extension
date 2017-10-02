<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\isInstanceOf as testedClass;

class isInstanceOf extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf(atoum\phpunit\constraint::class, new testedClass(new \stdClass));
    }

    public function testAssertInstanceOf()
    {
        $constraint = new testedClass(\stdClass::class);
        $this->assertSame($constraint, $constraint->evaluate(new \stdClass()));

        try {
            $constraint->evaluate(new \exception());

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $this->assertEquals('object(Exception) is not an instance of stdClass', $exception->getMessage());
        }
    }

    public function testAssertInstanceOfThrowsExceptionForInvalidArgument()
    {
        $constraint = new testedClass(null);

        try {
            $constraint->evaluate(new \stdClass);

            $this->fail();
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Argument of mageekguy\atoum\asserters\phpObject::isInstanceOf() must be a class instance or a class name', $exception->getMessage());
        }
    }
}
