<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertEmpty\\(\\) with non\\-empty\\-array\\<string, PhpCsFixer\\\\Fixer\\\\FixerInterface\\> will always evaluate to false\\.$#',
	'identifier' => 'staticMethod.impossibleType',
	'count' => 1,
	'path' => __DIR__ . '/tests/Test/FixerProviderTest.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
