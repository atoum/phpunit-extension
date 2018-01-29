<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;
use PHPUnit;

class notCount extends count
{
    protected function matches($actual)
    {
        if ($this->analyzer->isInteger($this->expected) === false) {
            throw new PHPUnit\Framework\Exception('Expected value of ' . __CLASS__ . ' must be an integer');
        }

        switch (true) {
            case $this->analyzer->isArray($actual):
                $asserter = new phpArrayAsserter(null, $this->analyzer);
                $asserter->setWith($actual)->hasNotSize($this->expected, $this->description);
                break;

            case $actual instanceof \countable:
                $asserter = new asserters\sizeOf(null, $this->analyzer);
                $asserter->setWith($actual)->isNotEqualTo($this->expected, $this->description);
                break;

            case $actual instanceof \iteratorAggregate:
                $asserter = new asserters\integer(null, $this->analyzer);
                $asserter->setWith(iterator_count($actual->getIterator()))->isNotEqualTo($this->expected, $this->description);
                break;

            case $actual instanceof \traversable:
            case $actual instanceof \iterator:
                $asserter = new asserters\integer(null, $this->analyzer);
                $asserter->setWith(iterator_count($actual))->isNotEqualTo($this->expected);
                break;

            default:
                throw new PHPUnit\Framework\Exception('Actual value of ' . __CLASS__ . ' must be an array, a countable object or a traversable object');
        }
    }
}

class phpArrayAsserter extends asserters\phpArray
{
    public function hasNotSize($size, $failMessage = null)
    {
        if (count($this->valueIsSet()->value) != $size) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s has size %d, expected different size', $this, count($this->valueIsSet()->value), $size));
        }

        return $this;
    }
}
