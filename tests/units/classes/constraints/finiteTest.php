<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\finite as testedClass;

class finite extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
    }

    public function testAssertFinite()
    {
        $constraint = new testedClass();
        $this->assertSame($constraint, $constraint->evaluate(rand(0, PHP_INT_MAX)));

        $actual = INF;

        try {
            $constraint->evaluate($actual);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals($analyzer->getTypeOf($actual) . ' is not finite', $exception->getMessage());
        }
    }
}
