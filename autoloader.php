<?php
namespace mageekguy\atoum\phpunit;

use mageekguy\atoum;

atoum\autoloader::get()
	->addNamespaceAlias('atoum\phpunit', __NAMESPACE__)
	->addDirectory(__NAMESPACE__, __DIR__ . DIRECTORY_SEPARATOR . 'classes')
;

$isPhpUnit = isset($_SERVER['argv'][0]) && preg_match('/phpunit$/', $_SERVER['argv'][0]);

if ($isPhpUnit === false)
{
	$aliases = array(
		'PHPUnit_Framework_TestCase' => 'mageekguy\\atoum\\phpunit\\test',
		'PHPUnit_Framework_Constraint' => 'mageekguy\\atoum\\phpunit\\constraint',
		'PHPUnit_Framework_AssertionFailedError' => 'mageekguy\\atoum\\asserter\\exception',
		'PHPUnit_Framework_Exception' => 'mageekguy\\atoum\\exceptions\\runtime',
		'PHPUnit_Framework_ExpectationFailedException' => 'mageekguy\\atoum\\phpunit\\constraint\\exception',
	);

	foreach ($aliases as $phpunitClass => $atoumClass)
	{
		if (class_exists($phpunitClass))
		{
			throw new atoum\exceptions\logic(sprintf('Class %s already exists', $phpunitClass));
		}

		atoum\autoloader::get()->addClassAlias($phpunitClass, $atoumClass);
	}
}

require_once __DIR__ . DIRECTORY_SEPARATOR .'tests' . DIRECTORY_SEPARATOR . 'autoloader.php';
