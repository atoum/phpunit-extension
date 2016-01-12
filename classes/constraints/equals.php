<?php

namespace mageekguy\atoum\phpunit\constraints;


use mageekguy\atoum\asserter\exception;
use mageekguy\atoum\asserters\phpFloat;
use mageekguy\atoum\asserters\variable;
use mageekguy\atoum\phpunit\constraint;
use mageekguy\atoum\tools\variable\analyzer;

class equals extends constraint
{
    private $expected;
    private $delta;
    private $maxDepth;
    private $canonicalize;
    private $ignoreCase;
    private $analyzer;

    public function __construct($expected, $description = null, $delta = null, $maxDepth = null, $canonicalize = null, $ignoreCase = null, analyzer $analyzer = null)
    {
        $this->expected = $expected;
        $this->description = $description;
        $this->delta = $delta;
        $this->maxDepth = $maxDepth ?: 10;
        $this->canonicalize = (bool) $canonicalize;
        $this->ignoreCase = (bool) $ignoreCase;
        $this->analyzer = $analyzer ?: new analyzer();
    }

    protected function matches($actual)
    {
        if ($this->delta == null && $this->analyzer->isFloat($actual) === false && $this->analyzer->isFloat($this->expected) === false)
        {
            $asserter = new variable();

            try
            {
                if ($this->analyzer->isString($actual) && $this->ignoreCase)
                {
                    $actual = strtolower($actual);
                }

                if ($this->analyzer->isArray($actual) && $this->canonicalize)
                {
                    $actual = sort($actual);
                }

                $asserter->setWith($actual);

                if (($actual === 0 && $this->expected == '') || ($actual == '' && $this->expected === 0))
                {
                    $asserter->isIdenticalTo($this->expected);
                }
                else
                {
                    $expected = $this->expected;

                    if ($this->analyzer->isString($expected) && $this->ignoreCase)
                    {
                        $expected = strtolower($expected);
                    }

                    if ($this->analyzer->isArray($expected) && $this->canonicalize)
                    {
                        $expected = sort($expected);
                    }

                    $asserter->isEqualTo($expected);
                }
            }
            catch (exception $exception)
            {
                $this->description = $this->description ?: $exception->getMessage();

                return false;
            }
        }
        else
        {
            $asserter = new phpFloat();

            try
            {
                $asserter->setWith((float) $actual)->isNearlyEqualTo((float) $this->expected, $this->delta);
            }
            catch (exception $exception)
            {
                $this->description = $this->description ?: $exception->getMessage();

                return false;
            }
        }

        return true;
    }
}
