<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'rawMessage' => 'Comparison operation ">" between int<80200, 80599> and 80599 is always false.',
	'identifier' => 'greater.alwaysFalse',
	'count' => 1,
	'path' => __DIR__ . '/src/Ruleset/AbstractRuleset.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
