<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'autoloader.php';

use mageekguy\atoum\phpunit;
use mageekguy\atoum\autoloop;
use mageekguy\atoum\report\fields\runner\result\notifier;

$extension = new autoloop\extension($script);
$extension
    ->setWatchedFiles(array(__DIR__ . '/classes'))
    ->addToRunner($runner)
;

$extension = new phpunit\extension($script);
$extension->addToRunner($runner);

if (getenv('TRAVIS_PHP_VERSION') === '7.0')
{
    $script
        ->php('php -n -ddate.timezone=Europe/Paris')
        ->noCodeCoverage()
    ;
}

$script->noCodeCoverageForClasses('mageekguy\atoum\asserter');
$script->noCodeCoverageForClasses('mageekguy\atoum\asserters');

$notifier = new notifier\terminal();
$report = $script->addDefaultReport();
$report->addField($notifier);
