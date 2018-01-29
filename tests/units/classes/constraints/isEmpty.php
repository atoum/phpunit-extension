<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\isEmpty as testedClass;

class isEmpty extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraints\count', new testedClass());
    }

    public function testAssertStringIsEmpty()
    {
        $constraint = new testedClass();
        $constraint->evaluate('');

        try {
            $constraint->evaluate('foo');

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $analyzer = new atoum\tools\variable\analyzer();
            $diff = new atoum\tools\diff($analyzer->dump(''), $analyzer->dump('foo'));
            $this->assertEquals('string is not empty' . PHP_EOL . $diff, $exception->getMessage());
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
            $this->assertEquals('array(2) has size 2, expected size 0', $exception->getMessage());
        }
    }
}
