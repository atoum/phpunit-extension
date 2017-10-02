<?php

namespace mageekguy\atoum\phpunit\tests\units\asserters;

use mageekguy\atoum\phpunit\asserters\assertThat as testedClass;

class assertThat extends \PHPUnit\Framework\TestCase
{
    public function testClass()
    {
        $this->assertInstanceOf('mageekguy\atoum\asserter', new testedClass());
    }
}
