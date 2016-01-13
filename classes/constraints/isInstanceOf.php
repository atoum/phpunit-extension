<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters\object;
use mageekguy\atoum\exceptions\logic;
use mageekguy\atoum\phpunit\constraint;

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
        $asserter = new object();

        try
        {
            $asserter->setWith($actual)->isInstanceOf($this->expected);
        }
        catch (logic $exception)
        {
            throw new \PHPUnit_Framework_Exception($exception->getMessage());
        }
    }
}
