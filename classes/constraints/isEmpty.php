<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters\integer;
use mageekguy\atoum\asserters\phpArray;
use mageekguy\atoum\asserters\phpFloat;
use mageekguy\atoum\asserters\sizeOf;
use mageekguy\atoum\asserters\variable;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tests\units\asserters\phpString;
use mageekguy\atoum\tools\variable\analyzer;
use mageekguy\atoum\exceptions;

class isEmpty extends count
{
    public function __construct($description = null, analyzer $analyzer = null)
    {
        parent::__construct(0, $description, $analyzer);
    }

    protected function matches($actual)
    {
        try
        {
            return parent::matches($actual);
        }
        catch (exceptions\runtime $exception)
        {
            throw new exceptions\runtime('Actual value of ' . __CLASS__ . ' must be a string, an array, a countable object, a traversable object');
        }
    }
}
