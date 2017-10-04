# atoum/phpunit-extension [![Build Status](https://travis-ci.org/atoum/phpunit-extension.svg?branch=master)](https://travis-ci.org/atoum/phpunit-extension)

This atoum extensions allows to run your existing PHPUnit test suites
with atoum's engine! If you want to migrate from PHPUnit to atoum,
this extension is your best companion!

## Goals

Your project already has PHPUnit test suites. You felt in love with
atoum. You want to replace PHPUnit by atoum on your project. This
extension will allow you to run your PHPUnit test suites with atoum,
ensuring a smooth migration.

## Install it

The extension is still a work in progress. You need to require a
developpement branch of atoum.

Note: We need your help to complete the extension, so feel free to
test the extension and submit issues when you found one.

Install extension using [Composer](https://getcomposer.org):

```json
{
    "require-dev": {
        "atoum/atoum": "dev-virtual-hooks",
        "atoum/phpunit-extension": "~0.3.0"
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

By default, everything should work, simply run `atoum` as usual and
your test suites will execute.

If you want to switch a test suite from PHPUnit to atoum, and get all
the features from atoum, replace the parent class of your test suites
from `PHPUnit\Framework\TestCase` to `mageekguy\atoum\phpunit`:

```diff
-class EnumTest extends \PHPUnit\Framework\TestCase
+class EnumTest extends \mageekguy\atoum\phpunit
```

Enjoy!

## Support

### Helpers

| Method                                                                                   | Supported |
|------------------------------------------------------------------------------------------|:---------:|
| `fail`                                                                                   | ❌         |
| `markTestIncomplete`                                                                     | ❌         |
| `markTestSkipped`                                                                        | ✅         |
| *Total*                                                                                  | 33%       |

### Assertions

| Method                                                                                                             | Supported |
|--------------------------------------------------------------------------------------------------------------------|:---------:|
| `assertArrayHasKey(mixed $key, array $array[, string $message = ''])`                                              | ✅         |
| `assertArrayNotHasKey`                                                                                             | ❌         |
| `assertClassHasAttribute`                                                                                          | ❌         |
| `assertClassNotHasAttribute`                                                                                       | ❌         |
| `assertArraySubset(array $subset, array $array[, bool $strict = '', string $message = ''])`                        | ✅         |
| `assertClassHasStaticAttribute`                                                                                    | ❌         |
| `assertClassNotHasStaticAttribute`                                                                                 | ❌         |
| `assertContains(mixed $needle, iterable $haystack[, string $message = ''])`                                        | ✅         |
| `assertContains(string $needle, string $haystack[, string $message = '', boolean $ignoreCase = FALSE])`            | ✅         |
| `assertNotContains`                                                                                                | ❌         |
| `assertContainsOnly(string $type, iterable $haystack[, boolean $isNativeType = NULL, string $message = ''])`       | ✅         |
| `assertContainsOnlyInstancesOf(string $classname, iterable $haystack[, string $message = ''])`                     | ✅         |
| `assertNotContainsOnly`                                                                                            | ❌         |
| `assertCount($expectedCount, $haystack[, string $message = ''])`                                                   | ✅         |
| `assertNotCount`                                                                                                   | ❌         |
| `assertEmpty(mixed $actual[, string $message = ''])`                                                               | ✅         |
| `assertNotEmpty`                                                                                                   | ❌         |
| `assertEqualXMLStructure`                                                                                          | ❌         |
| `assertEquals(mixed $expected, mixed $actual[, string $message = ''])`                                             | ✅         |
| `assertEquals(float $expected, float $actual[, string $message = '', float $delta = 0])`                           | ✅         |
| `assertEquals(DOMDocument $expected, DOMDocument $actual[, string $message = ''])`                                 | ❌         |
| `assertEquals(object $expected, object $actual[, string $message = ''])`                                           | ✅         |
| `assertEquals(array $expected, array $actual[, string $message = ''])`                                             | ✅         |
| `assertNotEquals`                                                                                                  | ❌         |
| `assertFalse(bool $condition[, string $message = ''])`                                                             | ✅         |
| `assertNotFalse`                                                                                                   | ❌         |
| `assertFileEquals`                                                                                                 | ❌         |
| `assertFileNotEquals`                                                                                              | ❌         |
| `assertFileExists`                                                                                                 | ❌         |
| `assertFileNotExists`                                                                                              | ❌         |
| `assertGreaterThan(mixed $expected, mixed $actual[, string $message = ''])`                                        | ✅         |
| `assertGreaterThanOrEqual(mixed $expected, mixed $actual[, string $message = ''])`                                 | ✅         |
| `assertInfinite(mixed $variable[, string $message = ''])`                                                          | ✅         |
| `assertFinite(mixed $variable[, string $message = ''])`                                                            | ✅         |
| `assertInstanceOf($expected, $actual[, $message = ''])`                                                            | ✅         |
| `assertNotInstanceOf($expected, $actual[, $message = ''])`                                                         | ❌         |
| `assertInternalType($expected, $actual[, $message = ''])`                                                          | ✅         |
| `assertNotInternalType`                                                                                            | ❌         |
| `assertJsonFileEqualsJsonFile`                                                                                     | ❌         |
| `assertJsonStringEqualsJsonFile`                                                                                   | ❌         |
| `assertJsonStringEqualsJsonString`                                                                                 | ❌         |
| `assertLessThan`                                                                                                   | ❌         |
| `assertLessThanOrEqual`                                                                                            | ❌         |
| `assertNan(mixed $variable[, string $message = ''])`                                                               | ✅         |
| `assertNull(mixed $variable[, string $message = ''])`                                                              | ✅         |
| `assertNotNull(mixed $variable[, string $message = ''])`                                                           | ✅         |
| `assertObjectHasAttribute`                                                                                         | ❌         |
| `assertObjectNotHasAttribute`                                                                                      | ❌         |
| `assertRegExp`                                                                                                     | ❌         |
| `assertNotRegExp`                                                                                                  | ❌         |
| `assertStringMatchesFormat`                                                                                        | ❌         |
| `assertStringNotMatchesFormat`                                                                                     | ❌         |
| `assertStringMatchesFormatFile`                                                                                    | ❌         |
| `assertStringNotMatchesFormatFile`                                                                                 | ❌         |
| `assertSame(mixed $expected, mixed $actual[, string $message = ''])`                                               | ✅         |
| `assertNotSame(mixed $expected, mixed $actual[, string $message = ''])`                                            | ✅         |
| `assertStringEndsWith`                                                                                             | ❌         |
| `assertStringEndsNotWith`                                                                                          | ❌         |
| `assertStringEqualsFile`                                                                                           | ❌         |
| `assertStringNotEqualsFile`                                                                                        | ❌         |
| `assertStringStartsWith`                                                                                           | ❌         |
| `assertStringStartsNotWith`                                                                                        | ❌         |
| `assertThat(mixed $value, PHPUnit_Framework_Constraint $constraint[, $message = ''])`                              | ✅         |
| `assertTrue(bool $condition[, string $message = ''])`                                                              | ✅         |
| `assertNotTrue`                                                                                                    | ❌         |
| `assertXmlFileEqualsXmlFile`                                                                                       | ❌         |
| `assertXmlFileNotEqualsXmlFile`                                                                                    | ❌         |
| `assertXmlStringEqualsXmlFile`                                                                                     | ❌         |
| `assertXmlStringNotEqualsXmlFile`                                                                                  | ❌         |
| `assertXmlStringEqualsXmlString`                                                                                   | ❌         |
| `assertXmlStringNotEqualsXmlString`                                                                                | ❌         |
| *Total*                                                                                                            | 36.62%    |

### Classes

| Class                          | Supported | Mapped to                            |
|--------------------------------|:---------:|--------------------------------------|
| `PHPUnit\Framework\TestCase`   | ✅         | `mageekguy\atoum\phpunit\test`       |
| `PHPUnit\Framework\Constraint` | ✅         | `mageekguy\atoum\phpunit\constraint` |
| *Total*                        | 100%      |                                      |

### Exceptions

| Class                                          | Supported | Mapped to                                      |
|------------------------------------------------|:---------:|------------------------------------------------|
| `PHPUnit\Framework\AssertionFailedError`       | ✅         | `mageekguy\atoum\asserter\exception`           |
| `PHPUnit\Framework\Exception`                  | ✅         | `mageekguy\atoum\exceptions\runtime`           |
| `PHPUnit\Framework\ExpectationFailedException` | ✅         | `mageekguy\atoum\phpunit\constraint\exception` |
| *Total*                                        | 100%      |                                                |

### Annotations

| Annotation                        | Supported | Note                                              |
|-----------------------------------|:---------:|:-------------------------------------------------:|
| `@author`                         | ✅         |                                                   |
| `@after`                          | ❌         |                                                   |
| `@afterClass`                     | ❌         |                                                   |
| `@backupGlobals`                  | ❌         |                                                   |
| `@backupStaticAttributes`         | ❌         |                                                   |
| `@before`                         | ❌         |                                                   |
| `@beforeClass`                    | ❌         |                                                   |
| `@codeCoverageIgnore*`            | ❌         |                                                   |
| `@covers`                         | ❌         |                                                   |
| `@coversDefaultClass`             | ❌         |                                                   |
| `@coversNothing`                  | ❌         |                                                   |
| `@dataProvider`                   | ✅         |                                                   |
| `@depends`                        | ❌         |                                                   |
| `@expectedException`              | ❌         |                                                   |
| `@expectedExceptionCode`          | ❌         |                                                   |
| `@expectedExceptionMessage`       | ❌         |                                                   |
| `@expectedExceptionMessageRegExp` | ❌         |                                                   |
| `@group`                          | ✅         |                                                   |
| `@large`                          | ✅         | Does not support strict-mode failures             |
| `@medium`                         | ✅         | Does not support strict-mode failures             |
| `@preserveGlobalState`            | ❌         |                                                   |
| `@requires`                       | ❌         |                                                   |
| `@runTestsInSeparateProcesses`    | ✅         | Does not preserve global state in child processes |
| `@runInSeparateProcess`           | ✅         | Does not preserve global state in child processes |
| `@small`                          | ✅         | Does not support strict-mode failures             |
| `@test`                           | ❌         |                                                   |
| `@testdox`                        | ❌         |                                                   |
| `@ticket`                         | ❌         |                                                   |
| `@uses`                           | ❌         |                                                   |
| *Total*                           | 27.58%    |                                                   |

## Links

* [atoum](http://atoum.org)
* [atoum's documentation](http://docs.atoum.org)
* [PHPUnit](https://phpunit.de/)


## License

phpunit-extension is released under the BSD-3-Clause License. See the bundled LICENSE file for details.

![atoum](http://atoum.org/images/logo/atoum.png)
