<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\objectHasAttribute as testedClass;

class objectHasAttribute extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass('foo'));
    }

    public function testAssertObjectHasAttribute()
    {
        $constraint  = new testedClass('foo');
        $object      = new \StdClass();
        $object->foo = 42;

        $this->assertSame($constraint, $constraint->evaluate($object));
    }

    public function testAssertObjectHasNotAttribute()
    {
        $constraint  = new testedClass('foo');
        $object      = new \StdClass();

        try {
            $this->assertSame($constraint, $constraint->evaluate($object));
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals(
                $analyzer->getTypeOf($object) . ' has no attribute `foo`',
                $exception->getMessage()
            );
        }
    }
}
