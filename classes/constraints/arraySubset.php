<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\tools\variable\analyzer;

class arraySubset extends constraint
{
    private $analyzer;
    private $expected;
    private $strict;

    public function __construct(array $expected, $description = null, $strict = null, analyzer $analyzer = null)
    {
        $this->analyzer = $analyzer ?: new analyzer();
        $this->expected = $expected;
        $this->description = $description;
        $this->strict = (bool) $strict;
    }

    protected function matches($actual)
    {
        if ($this->analyzer->isArray($actual) === false)
        {
            throw new \PHPUnit_Framework_Exception('Actual value of ' . __CLASS__ . ' must be an array');
        }

        $patched = array_replace_recursive($actual, $this->expected);
        $asserter = new asserters\phpArray();
        $asserter->setWith($actual);

        if ($this->strict)
        {
            $asserter->isIdenticalTo($patched);
        }
        else
        {
            $asserter->isEqualTo($patched);
        }
    }
}
