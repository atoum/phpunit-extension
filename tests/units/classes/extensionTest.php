<?php

namespace mageekguy\atoum\phpunit\tests\units;

use mageekguy\atoum\phpunit\extension as testedClass;

class extension extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\extension', new testedClass());
    }
}
