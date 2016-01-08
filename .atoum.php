<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use mageekguy\atoum\phpunit;

$extension = new phpunit\extension($script);
$extension->addToRunner($runner);
