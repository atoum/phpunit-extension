<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use mageekguy\atoum;
use mageekguy\atoum\phpunit\constraints\arraySubset as testedClass;

class arraySubset extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass([]));
    }

    public function testAssertArraySubset()
    {
        $array = [
            'a' => 'item a',
            'b' => 'item b',
            'c' => ['a2' => 'item a2', 'b2' => 'item b2'],
            'd' => ['a2' => ['a3' => 'item a3', 'b3' => 'item b3']]
        ];

        $constraint = new testedClass(['a' => 'item a', 'c' => ['a2' => 'item a2']]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $constraint = new testedClass(['a' => 'item a', 'd' => ['a2' => ['b3' => 'item b3']]]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $expected = ['a' => 'bad value'];
        $constraint = new testedClass($expected);

        $analyzer = new atoum\tools\variable\analyzer();

        try {
            $constraint->evaluate($array);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $patched = array_replace_recursive($array, $expected);
            $diff = new atoum\tools\diffs\variable($patched, $array);
            $this->assertEquals($analyzer->getTypeOf($array) . ' is not equal to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
        }

        $expected = ['d' => ['a2' => ['bad index' => 'item b3']]];
        $constraint = new testedClass($expected);

        try {
            $constraint->evaluate($array);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $patched = array_replace_recursive($array, $expected);
            $diff = new atoum\tools\diffs\variable($patched, $array);
            $this->assertEquals($analyzer->getTypeOf($array) . ' is not equal to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
        }
    }

    public function testAssertArraySubsetWithDeepNestedArrays()
    {
        $array = [
            'path' => [
                'to' => [
                    'the' => [
                        'cake' => 'is a lie'
                    ]
                ]
            ]
        ];

        $constraint = new testedClass(['path' => []]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $constraint = new testedClass(['path' => ['to' => []]]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $constraint = new testedClass(['path' => ['to' => ['the' => []]]]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $constraint = new testedClass(['path' => ['to' => ['the' => ['cake' => 'is a lie']]]]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $expected = ['path' => ['to' => ['the' => ['cake' => 'is not a lie']]]];
        $constraint = new testedClass($expected);
        $analyzer = new atoum\tools\variable\analyzer();

        try {
            $constraint->evaluate($array);

            $this->fail();
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $patched = array_replace_recursive($array, $expected);
            $diff = new atoum\tools\diffs\variable($patched, $array);
            $this->assertEquals($analyzer->getTypeOf($array) . ' is not equal to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
        }
    }

    public function testAssertArraySubsetWithNoStrictCheckAndObjects()
    {
        $obj = new \stdClass;
        $reference = &$obj;
        $array = ['a' => $obj];

        $constraint = new testedClass(['a' => $reference]);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $constraint = new testedClass(['a' => new \stdClass]);
        $this->assertSame($constraint, $constraint->evaluate($array));
    }

    public function testAssertArraySubsetWithStrictCheckAndObjects()
    {
        $obj       = new \stdClass;
        $reference = &$obj;
        $array     = ['a' => $obj];

        $constraint = new testedClass(['a' => $reference], null, true);
        $this->assertSame($constraint, $constraint->evaluate($array));

        $expected = ['a' => new \stdClass];
        $constraint = new testedClass($expected, null, true);
        $analyzer = new atoum\tools\variable\analyzer();

        try {
            $constraint->evaluate($array);

            $this->fail('Strict recursive array check fail.');
        } catch (\PHPUnit\Framework\ExpectationFailedException $exception) {
            $patched = array_replace_recursive($array, $expected);
            $diff = new atoum\tools\diffs\variable($patched, $array);
            $this->assertEquals($analyzer->getTypeOf($array) . ' is not identical to ' . $analyzer->getTypeOf($patched) . PHP_EOL . $diff, $exception->getMessage());
        }
    }

    /**
     * @dataProvider assertArraySubsetInvalidArgumentProvider
     */
    public function testAssertArraySubsetRaisesExceptionForInvalidArguments($expected, $actual)
    {
        $constraint = new testedClass($expected);
        $analyzer = new atoum\tools\variable\analyzer();

        try {
            $this->assertSame($constraint, $constraint->evaluate($actual));

            $this->fail();
        } catch (\PHPUnit\Framework\Exception $exception) {
            $this->assertEquals('Actual value of mageekguy\atoum\phpunit\constraints\arraySubset must be an array', $exception->getMessage());
        }
    }

    public function assertArraySubsetInvalidArgumentProvider()
    {
        return [
            //array(false, array()),
            [[], false],
        ];
    }
}
