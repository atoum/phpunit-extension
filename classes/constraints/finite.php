<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;

class finite extends constraint
{
    private $analyzer;

    public function __construct($description = null, analyzer $analyzer = null)
    {
        $this->description = $description;
        $this->analyzer = $analyzer ?: new analyzer();
    }

    protected function matches($actual)
    {
        $asserter = new asserters\boolean();

        try {
            $asserter->setWith(is_finite($actual))->isTrue();
        } catch (exception $exception) {
            throw new exception($asserter, $this->analyzer->getTypeOf($actual) . ' is not finite');
        }
    }
}
