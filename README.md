# atoum/phpunit-extension [![Build Status](https://travis-ci.org/atoum/phpunit-extension.svg?branch=master)](https://travis-ci.org/atoum/phpunit-extension)

This extension allows you to launch your PHPUnit tests with atoum's engine.

This is especially usefull when migrating to atoum.

## Install it

The extension is still a work in progress. So, you need to require a developpement branch of atoum.

We need your help to complete the extension, so don't hesitate to test the extension and write and issue when you found one.

Install extension using [composer](https://getcomposer.org):

```json
{
    "require-dev": {
        "atoum/atoum": "dev-virtual-hooks",
        "atoum/phpunit-extension": "~1.0"
    }
}

```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use mageekguy\atoum\phpunit;

$extension = new phpunit\extension($script);

$extension->addToRunner($runner);
```

## Use it

You must change the parent class of your tests. For example, instead of `PHPUnit_Framework_TestCase`, extend `mageekguy\atoum\phpunit`.

```diff
-class EnumTest extends \PHPUnit_Framework_TestCase
+class EnumTest extends \mageekguy\atoum\phpunit
```

## Support

### Helpers

| Method                                                                                   | Supported |
|------------------------------------------------------------------------------------------|:---------:|
| `fail`                                                                                   | ✘         |
| `markTestIncomplete`                                                                     | ✘         |
| `markTestSkipped`                                                                        | ✔         |

### Assertions

| Method                                                                                                             | Supported |
|--------------------------------------------------------------------------------------------------------------------|:---------:|
| `assertArrayHasKey(mixed $key, array $array[, string $message = ''])`                                              | ✔         |
| `assertArrayNotHasKey`                                                                                             | ✘         |
| `assertClassHasAttribute`                                                                                          | ✘         |
| `assertClassNotHasAttribute`                                                                                       | ✘         |
| `assertArraySubset(array $subset, array $array[, bool $strict = '', string $message = ''])`                        | ✔         |
| `assertClassHasStaticAttribute`                                                                                    | ✘         |
| `assertClassNotHasStaticAttribute`                                                                                 | ✘         |
| `assertContains(mixed $needle, Iterator|array $haystack[, string $message = ''])`                                  | ✔         |
| `assertContains(string $needle, string $haystack[, string $message = '', boolean $ignoreCase = FALSE])`            | ✔         |
| `assertNotContains`                                                                                                | ✘         |
| `assertContainsOnly(string $type, Iterator|array $haystack[, boolean $isNativeType = NULL, string $message = ''])` | ✔         |
| `assertContainsOnlyInstancesOf(string $classname, Traversable|array $haystack[, string $message = ''])`            | ✔         |
| `assertNotContainsOnly`                                                                                            | ✘         |
| `assertCount($expectedCount, $haystack[, string $message = ''])`                                                   | ✔         |
| `assertNotCount`                                                                                                   | ✘         |
| `assertEmpty(mixed $actual[, string $message = ''])`                                                               | ✔         |
| `assertNotEmpty`                                                                                                   | ✘         |
| `assertEqualXMLStructure`                                                                                          | ✘         |
| `assertEquals(mixed $expected, mixed $actual[, string $message = ''])`                                             | ✔         |
| `assertEquals(float $expected, float $actual[, string $message = '', float $delta = 0])`                           | ✔         |
| `assertEquals(DOMDocument $expected, DOMDocument $actual[, string $message = ''])`                                 | ✘         |
| `assertEquals(object $expected, object $actual[, string $message = ''])`                                           | ✔         |
| `assertEquals(array $expected, array $actual[, string $message = ''])`                                             | ✔         |
| `assertNotEquals`                                                                                                  | ✘         |
| `assertFalse(bool $condition[, string $message = ''])`                                                             | ✔         |
| `assertNotFalse`                                                                                                   | ✘         |
| `assertFileEquals`                                                                                                 | ✘         |
| `assertFileNotEquals`                                                                                              | ✘         |
| `assertFileExists`                                                                                                 | ✘         |
| `assertFileNotExists`                                                                                              | ✘         |
| `assertGreaterThan(mixed $expected, mixed $actual[, string $message = ''])`                                        | ✔         |
| `assertGreaterThanOrEqual(mixed $expected, mixed $actual[, string $message = ''])`                                 | ✔         |
| `assertInfinite(mixed $variable[, string $message = ''])`                                                          | ✔         |
| `assertFinite(mixed $variable[, string $message = ''])`                                                            | ✔         |
| `assertInstanceOf($expected, $actual[, $message = ''])`                                                            | ✔         |
| `assertNotInstanceOf($expected, $actual[, $message = ''])`                                                         | ✘         |
| `assertInternalType($expected, $actual[, $message = ''])`                                                          | ✔         |
| `assertNotInternalType`                                                                                            | ✘         |
| `assertJsonFileEqualsJsonFile`                                                                                     | ✘         |
| `assertJsonStringEqualsJsonFile`                                                                                   | ✘         |
| `assertJsonStringEqualsJsonString`                                                                                 | ✘         |
| `assertLessThan`                                                                                                   | ✘         |
| `assertLessThanOrEqual`                                                                                            | ✘         |
| `assertNan(mixed $variable[, string $message = ''])`                                                               | ✔         |
| `assertNull(mixed $variable[, string $message = ''])`                                                              | ✔         |
| `assertNotNull(mixed $variable[, string $message = ''])`                                                           | ✔         |
| `assertObjectHasAttribute`                                                                                         | ✘         |
| `assertObjectNotHasAttribute`                                                                                      | ✘         |
| `assertRegExp`                                                                                                     | ✘         |
| `assertNotRegExp`                                                                                                  | ✘         |
| `assertStringMatchesFormat`                                                                                        | ✘         |
| `assertStringNotMatchesFormat`                                                                                     | ✘         |
| `assertStringMatchesFormatFile`                                                                                    | ✘         |
| `assertStringNotMatchesFormatFile`                                                                                 | ✘         |
| `assertSame(mixed $expected, mixed $actual[, string $message = ''])`                                               | ✔         |
| `assertNotSame(mixed $expected, mixed $actual[, string $message = ''])`                                            | ✔         |
| `assertStringEndsWith`                                                                                             | ✘         |
| `assertStringEndsNotWith`                                                                                          | ✘         |
| `assertStringEqualsFile`                                                                                           | ✘         |
| `assertStringNotEqualsFile`                                                                                        | ✘         |
| `assertStringStartsWith`                                                                                           | ✘         |
| `assertStringStartsNotWith`                                                                                        | ✘         |
| `assertThat(mixed $value, PHPUnit_Framework_Constraint $constraint[, $message = ''])`                              | ✔         |
| `assertTrue(bool $condition[, string $message = ''])`                                                              | ✔         |
| `assertNotTrue`                                                                                                    | ✘         |
| `assertXmlFileEqualsXmlFile`                                                                                       | ✘         |
| `assertXmlFileNotEqualsXmlFile`                                                                                    | ✘         |
| `assertXmlStringEqualsXmlFile`                                                                                     | ✘         |
| `assertXmlStringNotEqualsXmlFile`                                                                                  | ✘         |
| `assertXmlStringEqualsXmlString`                                                                                   | ✘         |
| `assertXmlStringNotEqualsXmlString`                                                                                | ✘         |

### Classes

| Class                          | Supported | Mapped to                            |
|--------------------------------|:---------:|--------------------------------------|
| `PHPUnit_Framework_TestCase`   | ✔         | `mageekguy\atoum\phpunit\test`       |
| `PHPUnit_Framework_Constraint` | ✔         | `mageekguy\atoum\phpunit\constraint` |

### Exceptions

| Class                                          | Supported | Mapped to                                      |
|------------------------------------------------|:---------:|------------------------------------------------|
| `PHPUnit_Framework_AssertionFailedError`       | ✔         | `mageekguy\atoum\asserter\exception`           |
| `PHPUnit_Framework_Exception`                  | ✔         | `mageekguy\atoum\exceptions\runtime`           |
| `PHPUnit_Framework_ExpectationFailedException` | ✔         | `mageekguy\atoum\phpunit\constraint\exception` |

### Annotations

| Annotation                        | Supported | Note                                              |
|-----------------------------------|:---------:|:-------------------------------------------------:|
| `@author`                         | ✔         |                                                   |
| `@after`                          | ✘         |                                                   |
| `@afterClass`                     | ✘         |                                                   |
| `@backupGlobals`                  | ✘         |                                                   |
| `@backupStaticAttributes`         | ✘         |                                                   |
| `@before`                         | ✘         |                                                   |
| `@beforeClass`                    | ✘         |                                                   |
| `@codeCoverageIgnore*`            | ✘         |                                                   |
| `@covers`                         | ✘         |                                                   |
| `@coversDefaultClass`             | ✘         |                                                   |
| `@coversNothing`                  | ✘         |                                                   |
| `@dataProvider`                   | ✔         |                                                   |
| `@depends`                        | ✘         |                                                   |
| `@expectedException`              | ✘         |                                                   |
| `@expectedExceptionCode`          | ✘         |                                                   |
| `@expectedExceptionMessage`       | ✘         |                                                   |
| `@expectedExceptionMessageRegExp` | ✘         |                                                   |
| `@group`                          | ✔         |                                                   |
| `@large`                          | ✔         | Does not support strict-mode failures             |
| `@medium`                         | ✔         | Does not support strict-mode failures             |
| `@preserveGlobalState`            | ✘         |                                                   |
| `@requires`                       | ✘         |                                                   |
| `@runTestsInSeparateProcesses`    | ✔         | Does not preserve global state in child processes |
| `@runInSeparateProcess`           | ✔         | Does not preserve global state in child processes |
| `@small`                          | ✔         | Does not support strict-mode failures             |
| `@test`                           | ✘         |                                                   |
| `@testdox`                        | ✘         |                                                   |
| `@ticket`                         | ✘         |                                                   |
| `@uses`                           | ✘         |                                                   |

## Links

* [atoum](http://atoum.org)
* [atoum's documentation](http://docs.atoum.org)
* [PHPUnit](https://phpunit.de/)


## Licence

phpunit-extension is released under the BSD-3-Clause License. See the bundled LICENSE file for details.

![atoum](http://atoum.org/images/logo/atoum.png)
