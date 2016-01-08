<?php

namespace mageekguy\atoum\phpunit\tests;

use mageekguy\atoum;

atoum\autoloader::get()
	->addDirectory(__NAMESPACE__, __DIR__);
;
