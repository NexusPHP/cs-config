<?php

declare(strict_types=1);

/**
 * This file is part of NexusPHP CS Config.
 *
 * (c) 2020 John Paul E. Balandan, CPA <paulbalandan@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Nexus\CsConfig\Test;

use Nexus\CsConfig\Ruleset\RulesetInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet;
use PHPUnit\Framework\TestCase;

abstract class AbstractRulesetTestCase extends TestCase
{
    /**
     * @codeCoverageIgnore
     *
     * @return iterable
     */
    final public static function ruleNamesProvider(): iterable
    {
        $ruleset = static::createRuleset();

        return [
            [$ruleset->getName(), array_keys($ruleset->getRules())],
        ];
    }

    protected static function createRuleset(): RulesetInterface
    {
        $className = preg_replace('/^(Nexus\\\\CsConfig)\\\\Tests(\\\\.+)Test$/', '$1$2', static::class);

        return new $className();
    }

    final public function testAllConfiguredRulesAreBuiltIn(): void
    {
        $fixersNotBuiltIn = array_diff(
            $this->configuredFixers(),
            $this->builtInFixers()
        );

        sort($fixersNotBuiltIn);
        $c = \count($fixersNotBuiltIn);

        $this->assertEmpty($fixersNotBuiltIn, sprintf(
            'Failed asserting that %s for the %s "%s" %s built-in to PhpCsFixer.',
            $c > 1 ? 'fixers' : 'fixer',
            $c > 1 ? 'rules' : 'rule',
            implode('", "', $fixersNotBuiltIn),
            $c > 1 ? 'are' : 'is'
        ));
    }

    /**
     * @dataProvider ruleNamesProvider
     *
     * @param string $source
     * @param array  $rules
     *
     * @return void
     */
    final public function testRulesAreSortedByName(string $source, array $rules): void
    {
        $sorted = $rules;
        sort($sorted);

        $this->assertSame($sorted, $rules, sprintf(
            'Failed asserting that the rules in "%s" are sorted by name.',
            $source
        ));
    }

    final public function testAllBuiltInRulesAreConfigured(): void
    {
        $fixersWithoutConfiguration = array_diff(
            $this->builtInFixers(),
            $this->configuredFixers()
        );

        sort($fixersWithoutConfiguration);
        $c = \count($fixersWithoutConfiguration);

        $this->assertEmpty($fixersWithoutConfiguration, sprintf(
            'Failed asserting that built-in %s for the %s "%s" %s configured in this ruleset.',
            $c > 1 ? 'fixers' : 'fixer',
            $c > 1 ? 'rules' : 'rule',
            implode('", "', $fixersWithoutConfiguration),
            $c > 1 ? 'are' : 'is'
        ));
    }

    final public function testHeaderCommentFixerIsDisabledByDefault(): void
    {
        $rules = self::createRuleset()->getRules();

        $this->assertArrayHasKey('header_comment', $rules);
        $this->assertFalse($rules['header_comment']);
    }

    /**
     * Rules defined by PhpCsFixer.
     *
     * @return string[]
     */
    private function builtInFixers(): array
    {
        static $builtInFixers;

        if (null === $builtInFixers) {
            $fixerFactory = FixerFactory::create();
            $fixerFactory->registerBuiltInFixers();

            $builtInFixers = array_map(static function (FixerInterface $fixer): string {
                return $fixer->getName();
            }, $fixerFactory->getFixers());
        }

        return $builtInFixers;
    }

    /**
     * Rules defined by this ruleset.
     *
     * @return string[]
     */
    private function configuredFixers(): array
    {
        $rules = array_map(static function ($ruleConfiguration): bool {
            return true;
        }, static::createRuleset()->getRules());

        return array_keys(RuleSet::create($rules)->getRules());
    }
}
