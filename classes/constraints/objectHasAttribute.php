<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;
use PHPUnit;

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
        $this->asserter = new objectHasAttributeAsserter(null, $this->analyzer);
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

class objectHasAttributeAsserter extends asserters\phpObject
{
    public function hasAttribute($attribute, $failMessage = null)
    {
        if (property_exists($this->valueIsSet()->value, $attribute)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s has no attribute `%s`', $this, $attribute));
        }

        return $this;
    }
};
