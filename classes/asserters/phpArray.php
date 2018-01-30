<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class phpArray extends atoum\asserters\phpArray
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
