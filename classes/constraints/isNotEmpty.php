<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters as atoumAsserters;
use mageekguy\atoum\phpunit\asserters as atoumPHPUnitAsserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;

class isNotEmpty extends constraint
{
    private $analyzer;

    public function __construct($description = null, analyzer $analyzer = null)
    {
        $this->description = $description;
        $this->analyzer = $analyzer ?: new analyzer();
    }

    protected function matches($actual)
    {
        if ($actual instanceof \countable) {
            $asserter = new atoumAsserters\sizeOf(null, $this->analyzer);
            $asserter->setWith($actual)->isNotEqualTo(0, $this->description);
        } else {
            $asserter = new atoumPHPUnitAsserters\variable(null, $this->analyzer);
            $asserter->setWith($actual)->isNotEmpty($this->description);
        }
    }
}
