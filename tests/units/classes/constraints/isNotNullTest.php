<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\isNotNull as testedClass;

class isNotNull extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
    }

    public function testFails()
    {
        $constraint = new testedClass();

        try {
            $constraint->evaluate(null);
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();

            $this->assertEquals($analyzer->getTypeOf(null) . ' is null', $exception->getMessage());
        }
    }

    /**
     * @dataProvider notNullProvider
     */
    public function testPasses($actual)
    {
        $constraint = new testedClass();
        $this->assertSame($constraint, $constraint->evaluate($actual));
    }

    public function notNullProvider()
    {
        return [
            [''],
            [0],
            [false],
            [uniqid()]
        ];
    }
}
