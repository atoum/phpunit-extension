<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;
use mageekguy\atoum\exceptions;

class boolean extends constraint
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
        if ($this->analyzer->isBoolean($this->expected) === false)
        {
            throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must be a boolean');
        }

        $asserter = new asserters\boolean();
        $asserter->setWith($actual);

        if ($this->expected)
        {
            $asserter->isTrue();
        }
        else
        {
            $asserter->isFalse();
        }
    }
}
