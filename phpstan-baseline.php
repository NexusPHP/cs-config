<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'rawMessage' => 'Access to constant VERSION of internal class PhpCsFixer\\Console\\Application from outside its root namespace PhpCsFixer.',
	'identifier' => 'classConstant.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Comparison operation ">" between int<80200, 80599> and 80599 is always false.',
	'identifier' => 'greater.alwaysFalse',
	'count' => 1,
	'path' => __DIR__ . '/src/Ruleset/AbstractRuleset.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Call to method __construct() of internal class PhpCsFixer\\FixerFactory from outside its root namespace PhpCsFixer.',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Call to method __construct() of internal class PhpCsFixer\\RuleSet\\RuleSet from outside its root namespace PhpCsFixer.',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Call to method getFixers() of internal class PhpCsFixer\\FixerFactory from outside its root namespace PhpCsFixer.',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Call to method getRules() of internal class PhpCsFixer\\RuleSet\\RuleSet from outside its root namespace PhpCsFixer.',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Call to method registerBuiltInFixers() of internal class PhpCsFixer\\FixerFactory from outside its root namespace PhpCsFixer.',
	'identifier' => 'method.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Instantiation of internal class PhpCsFixer\\FixerFactory.',
	'identifier' => 'new.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Instantiation of internal class PhpCsFixer\\RuleSet\\RuleSet.',
	'identifier' => 'new.internalClass',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/FixerProvider.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
