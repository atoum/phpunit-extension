<?php

namespace mageekguy\atoum\phpunit
{

    use mageekguy\atoum\asserter\exception;
    use mageekguy\atoum\asserters\variable;

    class failingConstraint extends constraint
    {
        protected function matches($actual)
        {
            throw new exception(new variable(), uniqid());
        }
    }

    class passingConstraint extends constraint
    {
        protected function matches($actual) { }
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
            $message = uniqid();

            try
            {
                $constraint->evaluate(uniqid(), $message);

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
