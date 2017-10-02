<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\tools\variable\analyzer;

class greaterThanOrEqual extends greaterThan
{
    private $expected;

    public function __construct($expected, $description = null, analyzer $analyzer = null)
    {
        parent::__construct($expected, $description, $analyzer);

        $this->expected = $expected;
    }

    protected function matches($actual)
    {
        try {
            parent::matches($actual);
        } catch (exception $exception) {
            if (is_float($actual)) {
                $asserter = new asserters\phpFloat();
            } else {
                $asserter = new asserters\integer();
            }


            $asserter->setWith($actual)->isGreaterThanOrEqualTo($this->expected);
        }
    }
}
