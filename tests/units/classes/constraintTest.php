<?php

namespace mageekguy\atoum\phpunit
{
    class failingConstraint extends constraint
    {
        protected function matches($actual)
        {
            return false;
        }
    }

    class passingConstraint extends constraint
    {
        protected function matches($actual)
        {
            return true;
        }
    }
}

namespace mageekguy\atoum\phpunit\tests\units
{
    use mageekguy\atoum\phpunit\failingConstraint;
    use mageekguy\atoum\phpunit\passingConstraint;

    class constraint extends \PHPUnit_Framework_TestCase
    {
        public function testEvaluate()
        {
            $constraint = new failingConstraint();

            try
            {
                $constraint->evaluate(uniqid(), $message = uniqid());

                $this->fail();
            }
            catch (\PHPUnit_Framework_ExpectationFailedException $exception)
            {
                $this->assertEquals($message, $exception->getMessage());
            }

            $this->assertEquals(false, $constraint->evaluate(uniqid(), null, true));

            $constraint = new passingConstraint();

            $this->assertSame($constraint, $constraint->evaluate(uniqid()));
            $this->assertEquals(true, $constraint->evaluate(uniqid(), null, true));
        }

        public function testCount()
        {
            $constraint = new passingConstraint();

            $this->assertEquals(1, $constraint->count());
        }
    }
}
