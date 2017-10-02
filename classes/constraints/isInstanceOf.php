<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters;
use mageekguy\atoum\exceptions\logic;
use mageekguy\atoum\phpunit\constraint;
use PHPUnit;

class isInstanceOf extends constraint
{
    private $expected;

    public function __construct($expected, $description = null)
    {
        $this->expected = $expected;
        $this->description = $description;
    }

    protected function matches($actual)
    {
        $asserter = new asserters\phpObject();

        try {
            $asserter->setWith($actual)->isInstanceOf($this->expected);
        } catch (logic $exception) {
            throw new PHPUnit\Framework\Exception($exception->getMessage());
        }
    }
}
