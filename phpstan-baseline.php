<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertInstanceOf\\(\\) with arguments \'PhpCsFixer\\\\\\\\FixerDefinition\\\\\\\\CodeSampleInterface\', PhpCsFixer\\\\FixerDefinition\\\\CodeSampleInterface and string will always evaluate to true\\.$#',
	'identifier' => 'staticMethod.alreadyNarrowedType',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/AbstractCustomFixerTestCase.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Nexus\\\\CsConfig\\\\Test\\\\AbstractCustomFixerTestCase\\:\\:getLinter\\(\\) should return PhpCsFixer\\\\Linter\\\\LinterInterface but returns mixed\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/AbstractCustomFixerTestCase.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Nexus\\\\CsConfig\\\\Tests\\\\Fixer\\\\Comment\\\\NoCodeSeparatorCommentFixerTest\\:\\:provideFixCases\\(\\) return type has no value type specified in iterable type iterable\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/tests/Fixer/Comment/NoCodeSeparatorCommentFixerTest.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Nexus\\\\CsConfig\\\\Tests\\\\Fixer\\\\Comment\\\\SpaceAfterCommentStartFixerTest\\:\\:provideFixCases\\(\\) return type has no value type specified in iterable type iterable\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/tests/Fixer/Comment/SpaceAfterCommentStartFixerTest.php',
];
$ignoreErrors[] = [
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertEmpty\\(\\) with non\\-empty\\-array\\<string, PhpCsFixer\\\\Fixer\\\\FixerInterface\\> will always evaluate to false\\.$#',
	'identifier' => 'staticMethod.impossibleType',
	'count' => 1,
	'path' => __DIR__ . '/tests/Test/FixerProviderTest.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Nexus\\\\CsConfig\\\\Tests\\\\Test\\\\FixerProviderTest\\:\\:provideCreateMethodGivesNoDeprecatedBuiltInFixersCases\\(\\) return type has no value type specified in iterable type iterable\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/tests/Test/FixerProviderTest.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
