<?php

namespace mageekguy\atoum\phpunit\constraints;

use PHPUnit;
use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\phpunit\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;

class objectHasAttribute extends constraint
{
    private $analyzer;
    private $attribute;
    private $asserter;

    public function __construct($attribute, $description = null, analyzer $analyzer = null)
    {
        $this->analyzer = $analyzer ?: new analyzer();
        $this->attribute = $attribute;
        $this->description = $description;
        $this->asserter = new asserters\phpObject(null, $this->analyzer);
    }

    protected function matches($actual)
    {
        if ($this->analyzer->isObject($actual) === false) {
            throw new PHPUnit\Framework\Exception('Actual value of ' . __CLASS__ . ' must be an object');
        }

        if ($this->analyzer->isString($this->attribute) === false) {
            throw new PHPUnit\Framework\Exception('Attribute value of ' . __CLASS__ . ' must be a string');
        }

        $this->asserter->setWith($actual);
        $this->asserter->hasAttribute($this->attribute, $this->description);
    }
}
