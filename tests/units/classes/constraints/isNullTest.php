<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\isNull as testedClass;

class isNull extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass());
    }

    /**
     * @dataProvider notNullProvider
     */
    public function testFails($actual)
    {
        $constraint = new testedClass();

        try {
            $constraint->evaluate($actual);
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();

            $this->assertEquals($analyzer->getTypeOf($actual) . ' is not null', $exception->getMessage());
        }
    }

    public function testPasses()
    {
        $constraint = new testedClass();
        $this->assertSame($constraint, $constraint->evaluate(null));
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
