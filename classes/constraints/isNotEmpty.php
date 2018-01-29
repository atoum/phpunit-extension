<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters;
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
            $asserter = new asserters\sizeOf(null, $this->analyzer);
            $asserter->setWith($actual)->isNotEqualTo(0, $this->description);
        } else {
            $asserter = new notEmptyAsserter(null, $this->analyzer);
            $asserter->setWith($actual)->isNotEmpty($this->description);
        }
    }
}

class notEmptyAsserter extends asserters\variable
{
    public function isNotEmpty($failMessage = null)
    {
        if (!empty($this->valueIsSet()->value)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s is empty', $this));
        }

        return $this;
    }
}
