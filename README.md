# atoum PHPUnit extension [![Build Status](https://travis-ci.org/atoum/phpunit-extension.svg?branch=master)](https://travis-ci.org/atoum/phpunit-extension)

![atoum](http://downloads.atoum.org/images/logo.png)

## Install it

Install extension using [composer](https://getcomposer.org):

```json
{
    "require-dev": {
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
