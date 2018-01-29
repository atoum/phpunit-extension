<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\tools\variable\analyzer;

class isNotEmpty extends notCount
{
    public function __construct($description = null, analyzer $analyzer = null)
    {
        parent::__construct(0, $description, $analyzer);
    }

    protected function matches($actual)
    {
        if ($this->analyzer->isString($actual)) {
            $asserter = new asserters\phpString(null, $this->analyzer);
            $asserter->setWith($actual)->isNotEmpty($this->description);
        } else {
            try {
                parent::matches($actual);
            } catch (exceptions\runtime $exception) {
                throw new exceptions\runtime('Actual value of ' . __CLASS__ . ' must be a string, an array, a countable object, a traversable object');
            }
        }
    }
}
