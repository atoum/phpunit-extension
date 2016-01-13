<?php

namespace mageekguy\atoum\phpunit\tests\units\constraints;

use
	mageekguy\atoum,
	mageekguy\atoum\phpunit\constraints\same as testedClass
;

require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/Author.php';
require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/Book.php';
require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/ClassWithToString.php';
require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/SampleClass.php';
require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/tests/_files/Struct.php';

class same extends \PHPUnit_Framework_TestCase
{
	public function testClass()
	{
		$this->assertInstanceOf('mageekguy\atoum\phpunit\constraint', new testedClass(uniqid()));
	}

	/**
	 * @dataProvider sameProvider
	 */
	public function testAssertSameSucceeds($expected, $actual)
	{
		$constraint = new testedClass($expected);
		$this->assertSame($constraint, $constraint->evaluate($actual));
	}

	/**
	 * @dataProvider notSameProvider
	 */
	public function testAssertSameFails($expected, $actual)
	{
		$constraint = new testedClass($expected);

		try
		{
			$constraint->evaluate($actual);

			$this->fail();
		}
		catch (\PHPUnit_Framework_ExpectationFailedException $exception)
		{
			$this->assertInstanceOf('PHPUnit_Framework_ExpectationFailedException', $exception);
		}
	}

	public function sameProvider()
	{
		return $this->sameValues();
	}

	public function notSameProvider()
	{
		return array_merge($this->equalValues(), $this->notEqualValues());
	}

	protected function equalValues()
	{
		$book1                  = new \book();
		$book1->author          = new \author('Terry Pratchett');
		$book1->author->books[] = $book1;
		$book2                  = new \book();
		$book2->author          = new \author('Terry Pratchett');
		$book2->author->books[] = $book2;

		$object1  = new \sampleClass(4, 8, 15);
		$object2  = new \sampleClass(4, 8, 15);
		$storage1 = new \splObjectStorage();
		$storage1->attach($object1);
		$storage2 = new \splObjectStorage();
		$storage2->attach($object1);

		return array(
			array('a', 'A', 0, false, true),
			array(array('a' => 1, 'b' => 2), array('b' => 2, 'a' => 1)),
			array(array(1), array('1')),
			array(array(3, 2, 1), array(2, 3, 1), 0, true),
			array(2.3, 2.5, 0.5),
			// Asserting on floats (with delta) in arrays is not supported
			//array(array(2.3), array(2.5), 0.5),
			// Asserting on floats (with delta) in nested arrays is not supported
			//array(array(array(2.3)), array(array(2.5)), 0.5),
			// Asserting on floats (with delta) on objects\' properties is not supported
			//array(new \struct(2.3), new \struct(2.5), 0.5),
			// Asserting on floats (with delta) on objects\' properties in arrays is not supported
			//array(array(new \struct(2.3)), array(new \struct(2.5)), 0.5),
			array(1, 2, 1),
			array($object1, $object2),
			// Asserting on objects with cyclic dependencies is not supported
			//array($book1, $book2),
			array($storage1, $storage2),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
			),
			// Asserting on dates with delta is not supported
			//array(
			//	new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
			//	new \dateTime('2013-03-29 04:13:25', new \dateTimeZone('America/New_York')),
			//	10
			//),
			//array(
			//	new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
			//	new \dateTime('2013-03-29 04:14:40', new \dateTimeZone('America/New_York')),
			//	65
			//),
			array(
				new \dateTime('2013-03-29', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29', new \dateTimeZone('America/New_York')),
			),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 03:13:35', new \dateTimeZone('America/Chicago')),
			),
			// Asserting on dates with delta is not supported
			//array(
			//	new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
			//	new \dateTime('2013-03-29 03:13:49', new \dateTimeZone('America/Chicago')),
			//	15
			//),
			array(
				new \dateTime('2013-03-30', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 23:00:00', new \dateTimeZone('America/Chicago')),
			),
			// Asserting on dates with delta is not supported
			//array(
			//	new \dateTime('2013-03-30', new \dateTimeZone('America/New_York')),
			//	new \dateTime('2013-03-29 23:01:30', new \dateTimeZone('America/Chicago')),
			//	100
			//),
			array(
				new \dateTime('@1364616000'),
				new \dateTime('2013-03-29 23:00:00', new \dateTimeZone('America/Chicago')),
			),
			array(
				new \dateTime('2013-03-29T05:13:35-0500'),
				new \dateTime('2013-03-29T04:13:35-0600'),
			),
			array(0, '0'),
			array('0', 0),
			array(2.3, '2.3'),
			array('2.3', 2.3),
			array((string) (1/3), 1 - 2/3),
			array(1/3, (string) (1 - 2/3)),
			array('string representation', new \classWithToString()),
			array(new \classWithToString(), 'string representation'),
		);
	}

	protected function notEqualValues()
	{
		$book1                  = new \book();
		$book1->author          = new \author('Terry Pratchett');
		$book1->author->books[] = $book1;
		$book2                  = new \book();
		$book2->author          = new \author('Terry Pratch');
		$book2->author->books[] = $book2;

		$book3         = new \book();
		$book3->author = 'Terry Pratchett';
		$book4         = new \stdClass;
		$book4->author = 'Terry Pratchett';

		$object1  = new \sampleClass(4, 8, 15);
		$object2  = new \sampleClass(16, 23, 42);
		$object3  = new \sampleClass(4, 8, 15);
		$storage1 = new \splObjectStorage;
		$storage1->attach($object1);
		$storage2 = new \splObjectStorage;
		$storage2->attach($object3); // same content, different object

		return array(
			array('a', 'b'),
			array('a', 'A'),
			array('9E6666666','9E7777777'),
			array(1, 2),
			array(2, 1),
			array(2.3, 4.2),
			array(2.3, 4.2, 0.5),
			array(array(2.3), array(4.2), 0.5),
			array(array(array(2.3)), array(array(4.2)), 0.5),
			array(new \struct(2.3), new \struct(4.2), 0.5),
			array(array(new \struct(2.3)), array(new \struct(4.2)), 0.5),
			array(NAN, NAN),
			array(array(), array(0 => 1)),
			array(array(0     => 1), array()),
			array(array(0     => null), array()),
			array(array(0     => 1, 1 => 2), array(0     => 1, 1 => 3)),
			array(array('a', 'b' => array(1, 2)), array('a', 'b' => array(2, 1))),
			array(new \sampleClass(4, 8, 15), new \sampleClass(16, 23, 42)),
			array($object1, $object2),
			array($book1, $book2),
			array($book3, $book4),
			array(fopen(__FILE__, 'r'), fopen(__FILE__, 'r')),
			array($storage1, $storage2),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 03:13:35', new \dateTimeZone('America/New_York')),
			),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 03:13:35', new \dateTimeZone('America/New_York')),
				3500
			),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 05:13:35', new \dateTimeZone('America/New_York')),
				3500
			),
			array(
				new \dateTime('2013-03-29', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-30', new \dateTimeZone('America/New_York')),
			),
			array(
				new \dateTime('2013-03-29', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-30', new \dateTimeZone('America/New_York')),
				43200
			),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/Chicago')),
			),
			array(
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-29 04:13:35', new \dateTimeZone('America/Chicago')),
				3500
			),
			array(
				new \dateTime('2013-03-30', new \dateTimeZone('America/New_York')),
				new \dateTime('2013-03-30', new \dateTimeZone('America/Chicago')),
			),
			array(
				new \dateTime('2013-03-29T05:13:35-0600'),
				new \dateTime('2013-03-29T04:13:35-0600'),
			),
			array(
				new \dateTime('2013-03-29T05:13:35-0600'),
				new \dateTime('2013-03-29T05:13:35-0500'),
			),
			array(new \sampleClass(4, 8, 15), false),
			array(false, new \sampleClass(4, 8, 15)),
			array(array(0        => 1, 1 => 2), false),
			array(false, array(0 => 1, 1 => 2)),
			array(array(), new \stdClass()),
			array(new \stdClass(), array()),
			array(0, 'Foobar'),
			array('Foobar', 0),
			array(3, acos(8)),
			array(acos(8), 3)
		);
	}

	protected function sameValues()
	{
		$object = new \sampleClass(4, 8, 15);
		$resource = fopen(__FILE__, 'r');

		return array(
			array(null, null),
			array('a', 'a'),
			array(0, 0),
			array(2.3, 2.3),
			// Asserting on float is not supported
			//array(1/3, 1 - 2/3),
			array(log(0), log(0)),
			array(array(), array()),
			array(array(0 => 1), array(0 => 1)),
			array(array(0 => null), array(0 => null)),
			array(array('a', 'b' => array(1, 2)), array('a', 'b' => array(1, 2))),
			array($object, $object),
			array($resource, $resource),
		);
	}
}
