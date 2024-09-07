<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	// identifier: staticMethod.alreadyNarrowedType
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertInstanceOf\\(\\) with arguments \'PhpCsFixer\\\\\\\\FixerDefinition\\\\\\\\CodeSampleInterface\', PhpCsFixer\\\\FixerDefinition\\\\CodeSampleInterface and string will always evaluate to true\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/AbstractCustomFixerTestCase.php',
];
$ignoreErrors[] = [
	// identifier: staticMethod.alreadyNarrowedType
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertIsInt\\(\\) with int\\<0, max\\> will always evaluate to true\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/AbstractCustomFixerTestCase.php',
];
$ignoreErrors[] = [
	// identifier: staticMethod.alreadyNarrowedType
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertSame\\(\\) with arguments "\\\\n", string and string will always evaluate to true\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/AbstractCustomFixerTestCase.php',
];
$ignoreErrors[] = [
	// identifier: return.type
	'message' => '#^Method Nexus\\\\CsConfig\\\\Test\\\\AbstractCustomFixerTestCase\\:\\:getLinter\\(\\) should return PhpCsFixer\\\\Linter\\\\LinterInterface but returns mixed\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Test/AbstractCustomFixerTestCase.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Nexus\\\\CsConfig\\\\Tests\\\\Fixer\\\\Comment\\\\NoCodeSeparatorCommentFixerTest\\:\\:provideFixCases\\(\\) return type has no value type specified in iterable type iterable\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/tests/Fixer/Comment/NoCodeSeparatorCommentFixerTest.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Nexus\\\\CsConfig\\\\Tests\\\\Fixer\\\\Comment\\\\SpaceAfterCommentStartFixerTest\\:\\:provideFixCases\\(\\) return type has no value type specified in iterable type iterable\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/tests/Fixer/Comment/SpaceAfterCommentStartFixerTest.php',
];
$ignoreErrors[] = [
	// identifier: staticMethod.impossibleType
	'message' => '#^Call to static method PHPUnit\\\\Framework\\\\Assert\\:\\:assertEmpty\\(\\) with non\\-empty\\-array\\<string, PhpCsFixer\\\\Fixer\\\\FixerInterface\\> will always evaluate to false\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/tests/Test/FixerProviderTest.php',
];
$ignoreErrors[] = [
	// identifier: missingType.iterableValue
	'message' => '#^Method Nexus\\\\CsConfig\\\\Tests\\\\Test\\\\FixerProviderTest\\:\\:provideCreateMethodGivesNoDeprecatedBuiltInFixersCases\\(\\) return type has no value type specified in iterable type iterable\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/tests/Test/FixerProviderTest.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
