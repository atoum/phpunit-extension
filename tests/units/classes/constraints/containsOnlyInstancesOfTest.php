<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\containsOnlyInstancesOf as testedClass;

require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/SampleArrayAccess.php';

class containsOnlyInstancesOf extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(__CLASS__));
    }

    public function testAssertContainsOnlyInstancesOf()
    {
        $constraint = new testedClass('Book');
        $this->assertSame($constraint, $constraint->evaluate([new \book(), new \book()]));
        $this->assertSame($constraint, $constraint->evaluate(new \arrayIterator([new \book(), new \book()])));

        $constraint = new testedClass('stdClass');
        $this->assertSame($constraint, $constraint->evaluate([new \stdClass()]));

        $actual = [new \author('Test')];
        $expected = 'Book';
        $constraint = new testedClass($expected);

        try {
            $constraint->evaluate($actual);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $this->assertEquals($analyzer->getTypeOf($actual[0]) . ' is not an instance of Book', $exception->getMessage());
        }
    }

    public function testAssertContainsOnlyInstancesOfThrowsException()
    {
        $constraint = new testedClass(null);

        try {
            $constraint->evaluate([new \stdClass()]);
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Expected value of mageekguy\atoum\phpunit\constraints\containsOnlyInstancesOf must be a class instance or class name', $exception->getMessage());
        }

        $constraint = new testedClass('stdClass');

        try {
            $constraint->evaluate(null);
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\containsOnlyInstancesOf must be an array or a traversable object', $exception->getMessage());
        }
    }
}
