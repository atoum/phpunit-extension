<?php

use mageekguy\atoum;
use mageekguy\atoum\phpunit;
use mageekguy\atoum\scripts;

if (defined('mageekguy\atoum\scripts\runner') === true && (constant('mageekguy\atoum\version') === 'dev-master' || version_compare(constant('mageekguy\atoum\version'), '2.9.0-beta', '>=') === true)) {
    scripts\runner::addConfigurationCallable(function(atoum\configurator $script, atoum\runner $runner) {
        $extension = new phpunit\extension($script);
        $extension->addToRunner($runner);
    });
}