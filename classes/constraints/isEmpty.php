<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;

class isEmpty extends constraint
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
            $asserter->setWith($actual)->isEqualTo(0, $this->description);
        } else {
            $asserter = new emptyAsserter(null, $this->analyzer);
            $asserter->setWith($actual)->isEmpty($this->description);
        }
    }
}

class emptyAsserter extends asserters\variable
{
    public function isEmpty($failMessage = null)
    {
        if (empty($this->valueIsSet()->value)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s is not empty', $this));
        }

        return $this;
    }
}
