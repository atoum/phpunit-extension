<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters\variable;
use mageekguy\atoum\phpunit\constraint;

class same extends constraint
{
    private $expected;

    public function __construct($expected, $description = null)
    {
        $this->expected = $expected;
        $this->description = $description;
    }

    protected function matches($actual)
    {
        $asserter = new variable();

        try
        {
            $asserter->setWith($actual)->isIdenticalTo($this->expected);
        }
        catch (exception $exception)
        {
            $this->description = $this->description ?: $exception->getMessage();

            return false;
        }

        return true;
    }
}
