<?php

namespace mageekguy\atoum\phpunit\asserters;

use mageekguy\atoum;

class variable extends atoum\asserters\variable
{
    public function isEmpty($failMessage = null)
    {
        if (empty($this->valueIsSet()->value)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s is not empty', $this));
        }

        return $this;
    }

    public function isNotEmpty($failMessage = null)
    {
        if (!empty($this->valueIsSet()->value)) {
            $this->pass();
        } else {
            $this->fail($failMessage ?: $this->_('%s is empty', $this));
        }

        return $this;
    }
}
