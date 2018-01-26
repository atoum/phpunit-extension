<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\objectNotHasAttribute as testedClass;

class objectNotHasAttribute extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass('foo'));
    }

    public function testAssertObjectNotHasAttribute()
    {
        $constraint  = new testedClass('foo');
        $object      = new \StdClass();

        $this->assertSame($constraint, $constraint->evaluate($object));
    }

    public function testAssertObjectHasNotAttribute()
    {
        $constraint  = new testedClass('foo');
        $object      = new \StdClass();
        $object->foo = 42;

        try {
            $this->assertSame($constraint, $constraint->evaluate($object));
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals(
                $analyzer->getTypeOf($object) . ' has attribute `foo`',
                $exception->getMessage()
            );
        }
    }
}
