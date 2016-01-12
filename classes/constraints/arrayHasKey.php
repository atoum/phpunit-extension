<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters\boolean;
use mageekguy\atoum\asserters\phpArray;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\tools\variable\analyzer;

class arrayHasKey extends constraint
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
        if (is_null($this->expected) === true)
        {
            throw new \PHPUnit_Framework_Exception('Expected value of ' . __CLASS__ . ' must not be null');
        }

        if ($this->analyzer->isArray($actual) === false && $actual instanceof \arrayAccess === false)
        {
            throw new \PHPUnit_Framework_Exception('Actual value of ' . __CLASS__ . ' must be an array or an arrayAccess instance');
        }

        try
        {
            if ($this->analyzer->isArray($actual))
            {
                $asserter = new phpArray();
                $asserter->setWith($actual)->hasKey($this->expected);
            }
            else
            {
                try
                {
                    $asserter = new boolean();
                    $asserter->setWith(isset($actual[$this->expected]))->isTrue();
                }
                catch (exception $exception)
                {
                    throw new exception($asserter, $this->analyzer->getTypeOf($actual) . ' has no key ' . $this->analyzer->getTypeOf($this->expected));
                }
            }
        }
        catch (exception $exception)
        {
            $this->description = $this->description ?: $exception->getMessage();

            return false;
        }

        return true;
    }
}
