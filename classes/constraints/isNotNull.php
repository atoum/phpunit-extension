<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;
use mageekguy\atoum\exceptions;

class isNotNull extends constraint
{
    public function __construct($description = null)
    {
        $this->description = $description;
    }

    protected function matches($actual)
    {
        $asserter = new asserters\variable();
        $asserter->setWith($actual)->isNotNull();
    }
}
