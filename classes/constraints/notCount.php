<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters as atoumAsserters;
use mageekguy\atoum\phpunit\asserters as atoumPHPUnitAsserters;
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
                $asserter = new atoumPHPUnitAsserters\phpArray(null, $this->analyzer);
                $asserter->setWith($actual)->hasNotSize($this->expected, $this->description);
                break;

            case $actual instanceof \countable:
                $asserter = new atoumAsserters\sizeOf(null, $this->analyzer);
                $asserter->setWith($actual)->isNotEqualTo($this->expected, $this->description);
                break;

            case $actual instanceof \iteratorAggregate:
                $asserter = new atoumAsserters\integer(null, $this->analyzer);
                $asserter->setWith(iterator_count($actual->getIterator()))->isNotEqualTo($this->expected, $this->description);
                break;

            case $actual instanceof \traversable:
            case $actual instanceof \iterator:
                $asserter = new atoumAsserters\integer(null, $this->analyzer);
                $asserter->setWith(iterator_count($actual))->isNotEqualTo($this->expected);
                break;

            default:
                throw new PHPUnit\Framework\Exception('Actual value of ' . __CLASS__ . ' must be an array, a countable object or a traversable object');
        }
    }
}
