<?php

namespace mageekguy\atoum\phpunit;

use mageekguy\atoum\asserter\exception;
use PHPUnit;

abstract class constraint
{
    protected $description;

    public function evaluate($actual, $description = null, $return = null)
    {
        $return = (bool) $return;
        $result = $this->doesMatch($actual);

        if ($return) {
            return $result;
        }

        if ($result === false) {
            $this->fail($actual, $description ?: $this->description);
        }

        return $this;
    }

    public function count()
    {
        return 1;
    }

    abstract protected function matches($actual);

    protected function fail($actual, $message)
    {
        throw new PHPUnit\Framework\ExpectationFailedException($message);
    }

    private function doesMatch($actual)
    {
        try {
            $this->matches($actual);
        } catch (exception $exception) {
            $this->description = $this->description ?: $exception->getMessage();

            return false;
        }

        return true;
    }
}
