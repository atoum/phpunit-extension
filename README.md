# atoum PHPUnit extension [![Build Status](https://travis-ci.org/atoum/phpunit-extension.svg?branch=master)](https://travis-ci.org/atoum/phpunit-extension)

![atoum](http://downloads.atoum.org/images/logo.png)

## Install it

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
| `assertClassHasAttribute`                                                                                          | ✘         |
| `assertArraySubset(array $subset, array $array[, bool $strict = '', string $message = ''])`                        | ✔         |
| `assertClassHasStaticAttribute`                                                                                    | ✘         |
| `assertContains(mixed $needle, Iterator|array $haystack[, string $message = ''])`                                  | ✔         |
| `assertContains(string $needle, string $haystack[, string $message = '', boolean $ignoreCase = FALSE])`            | ✔         |
| `assertContainsOnly(string $type, Iterator|array $haystack[, boolean $isNativeType = NULL, string $message = ''])` | ✔         |
| `assertContainsOnlyInstancesOf(string $classname, Traversable|array $haystack[, string $message = ''])`            | ✔         |
| `assertCount($expectedCount, $haystack[, string $message = ''])`                                                   | ✔         |
| `assertEmpty(mixed $actual[, string $message = ''])`                                                               | ✔         |
| `assertEqualXMLStructure`                                                                                          | ✘         |
| `assertEquals(mixed $expected, mixed $actual[, string $message = ''])`                                             | ✔         |
| `assertEquals(float $expected, float $actual[, string $message = '', float $delta = 0])`                           | ✔         |
| `assertEquals(DOMDocument $expected, DOMDocument $actual[, string $message = ''])`                                 | ✘         |
| `assertEquals(object $expected, object $actual[, string $message = ''])`                                           | ✔         |
| `assertEquals(array $expected, array $actual[, string $message = ''])`                                             | ✔         |
| `assertFalse(bool $condition[, string $message = ''])`                                                             | ✔         |
| `assertFileEquals`                                                                                                 | ✘         |
| `assertFileExists`                                                                                                 | ✘         |
| `assertGreaterThan`                                                                                                | ✘         |
| `assertGreaterThanOrEqual`                                                                                         | ✘         |
| `assertInfinite`                                                                                                   | ✘         |
| `assertInstanceOf($expected, $actual[, $message = ''])`                                                            | ✔         |
| `assertInternalType`                                                                                               | ✘         |
| `assertJsonFileEqualsJsonFile`                                                                                     | ✘         |
| `assertJsonStringEqualsJsonFile`                                                                                   | ✘         |
| `assertJsonStringEqualsJsonString`                                                                                 | ✘         |
| `assertLessThan`                                                                                                   | ✘         |
| `assertLessThanOrEqual`                                                                                            | ✘         |
| `assertNan`                                                                                                        | ✘         |
| `assertNotNull(mixed $variable[, string $message = ''])`                                                           | ✔         |
| `assertNull(mixed $variable[, string $message = ''])`                                                              | ✔         |
| `assertObjectHasAttribute`                                                                                         | ✘         |
| `assertRegExp`                                                                                                     | ✘         |
| `assertStringMatchesFormat`                                                                                        | ✘         |
| `assertStringMatchesFormatFile`                                                                                    | ✘         |
| `assertSame(mixed $expected, mixed $actual[, string $message = ''])`                                               | ✔         |
| `assertStringEndsWith`                                                                                             | ✘         |
| `assertStringEqualsFile`                                                                                           | ✘         |
| `assertStringStartsWith`                                                                                           | ✘         |
| `assertThat`                                                                                                       | ✘         |
| `assertTrue(bool $condition[, string $message = ''])`                                                              | ✔         |
| `assertXmlFileEqualsXmlFile`                                                                                       | ✘         |
| `assertXmlStringEqualsXmlFile`                                                                                     | ✘         |
| `assertXmlStringEqualsXmlString`                                                                                   | ✘         |

### Exceptions

| Class                                          | Supported | Mapped to                                      |
|------------------------------------------------|:---------:|------------------------------------------------|
| `PHPUnit_Framework_AssertionFailedError`       | ✔         | `mageekguy\atoum\asserter\exception`           |
| `PHPUnit_Framework_Exception`                  | ✔         | `mageekguy\atoum\exceptions\runtime`           |
| `PHPUnit_Framework_ExpectationFailedException` | ✔         | `mageekguy\atoum\phpunit\constraint\exception` |
