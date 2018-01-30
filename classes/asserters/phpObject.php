<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class phpObject extends atoum\asserters\phpObject
{
    public function hasAttribute($attribute, $failMessage = null)
    {
        if (property_exists($this->valueIsSet()->value, $attribute)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s has no attribute `%s`', $this, $attribute));
        }

        return $this;
    }

    public function hasNotAttribute($attribute, $failMessage = null)
    {
        if (false === property_exists($this->valueIsSet()->value, $attribute)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s has attribute `%s`', $this, $attribute));
        }

        return $this;
    }
}
