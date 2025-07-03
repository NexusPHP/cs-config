<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Call to method __construct\\(\\) of internal class PhpCsFixer\\\\FixerFactory from outside its root namespace PhpCsFixer\\.$#',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Call to method __construct\\(\\) of internal class PhpCsFixer\\\\RuleSet\\\\RuleSet from outside its root namespace PhpCsFixer\\.$#',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Call to method getFixers\\(\\) of internal class PhpCsFixer\\\\FixerFactory from outside its root namespace PhpCsFixer\\.$#',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Call to method getRules\\(\\) of internal class PhpCsFixer\\\\RuleSet\\\\RuleSet from outside its root namespace PhpCsFixer\\.$#',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Call to method registerBuiltInFixers\\(\\) of internal class PhpCsFixer\\\\FixerFactory from outside its root namespace PhpCsFixer\\.$#',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Instantiation of internal class PhpCsFixer\\\\FixerFactory\\.$#',
	'identifier' => 'new.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Instantiation of internal class PhpCsFixer\\\\RuleSet\\\\RuleSet\\.$#',
	'identifier' => 'new.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertEmpty\\(\\) with non\\-empty\\-array\\<string, PhpCsFixer\\\\Fixer\\\\FixerInterface\\> will always evaluate to false\\.$#',
	'identifier' => 'staticMethod.impossibleType',
	'count' => 1,
	'path' => __DIR__ . '/tests/Test/FixerProviderTest.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
