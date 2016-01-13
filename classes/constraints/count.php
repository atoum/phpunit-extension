<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;
use mageekguy\atoum\exceptions;

class count extends constraint
{
    private $expected;
    private $analyzer;

    public function __construct($expected, $description = null, analyzer $analyzer = null)
    {
        $this->analyzer = $analyzer ?: new analyzer();
        $this->expected = $expected;
        $this->description = $description;
    }

    protected function matches($actual)
    {
        if ($this->analyzer->isInteger($this->expected) === false)
        {
            throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must be an integer');
        }

        switch (true)
        {
            case $this->analyzer->isArray($actual):
                $asserter = new asserters\phpArray();
                $asserter->setWith($actual)->hasSize($this->expected);
                break;

            case $actual instanceof \countable:
                $asserter = new asserters\sizeOf();
                $asserter->setWith($actual)->isEqualTo($this->expected);
                break;

            case $actual instanceof \iteratorAggregate:
                $asserter = new asserters\integer();
                $asserter->setWith(iterator_count($actual->getIterator()))->isEqualTo($this->expected);
                break;

            case $actual instanceof \traversable:
            case $actual instanceof \iterator:
                $asserter = new asserters\integer();
                $asserter->setWith(iterator_count($actual))->isEqualTo($this->expected);
                break;

            default:
                throw new \PHPUnit_Framework_Exception('Actual value of ' . __CLASS__ . ' must be an array, a countable object or a traversable object');
        }
    }
}
