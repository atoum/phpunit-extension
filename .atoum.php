<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use mageekguy\atoum\phpunit;

$extension = new phpunit\extension($script);
$extension->addToRunner($runner);

if (getenv('TRAVIS_PHP_VERSION') === '7.0')
{
    $script
        ->php('php -n -ddate.timezone=Europe/Paris')
        ->noCodeCoverage()
    ;
}
