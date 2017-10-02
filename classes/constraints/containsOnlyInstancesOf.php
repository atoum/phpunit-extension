<?php

namespace mageekguy\atoum\phpunit\constraints;

use mageekguy\atoum\asserters;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;
use PHPUnit;

class containsOnlyInstancesOf extends constraint
{
    private $analyzer;
    private $expected;

    public function __construct($expected, $description = null, analyzer $analyzer = null)
    {
        $this->analyzer = $analyzer ?: new analyzer();
        $this->expected = $expected;
        $this->description = $description;
    }

    protected function matches($actual)
    {
        if ($this->analyzer->isArray($actual) === false && $actual instanceof \traversable === false) {
            throw new PHPUnit\Framework\Exception('Actual value of ' . __CLASS__ . ' must be an array or a traversable object');
        }

        try {
            $asserter = new asserters\phpObject(null, $this->analyzer);

            foreach ($actual as $value) {
                $asserter->setWith($value)->isInstanceOf($this->expected);
            }
        } catch (exceptions\logic $exception) {
            throw new PHPUnit\Framework\Exception('Expected value of ' . __CLASS__ . ' must be a class instance or class name');
        }
    }
}
