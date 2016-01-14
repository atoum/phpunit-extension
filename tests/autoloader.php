<?php

namespace mageekguy\atoum\phpunit\tests;

use mageekguy\atoum;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

atoum\autoloader::get()
    ->addDirectory(__NAMESPACE__, __DIR__)
    ->addDirectory('mageekguy\atoum\autoloop', __DIR__ . DIRECTORY_SEPARATOR . '../vendor/atoum/autoloop-extension/classes')
    ->addDirectory('Lurker', __DIR__ . DIRECTORY_SEPARATOR . '../vendor/henrikbjorn/lurker/src/Lurker')
    ->addDirectory('Symfony\Component\EventDispatcher', __DIR__ . DIRECTORY_SEPARATOR . '../vendor/symfony/event-dispatcher')
    ->addDirectory('Symfony\Component\Config', __DIR__ . DIRECTORY_SEPARATOR . '../vendor/symfony/config')
;
