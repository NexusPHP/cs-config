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
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerConfiguration\DeprecatedFixerOptionInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionInterface;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet\RuleSet;
use PHPUnit\Framework\TestCase;

/**
 * Used for testing the rulesets.
 *
 * @codeCoverageIgnore
 */
abstract class AbstractRulesetTestCase extends TestCase
{
    /**
     * @var string[]
     */
    private static $configured = [];

    /**
     * @var string[]
     */
    private static $builtInFixers = [];

    /**
     * @var string[]
     */
    private static $cleanBuiltInFixers = [];

    /**
     * @var string[]
     */
    private static $deprecatedBuiltInFixers = [];

    public static function setUpBeforeClass(): void
    {
        self::reset();

        self::$configured = self::configuredFixers();
        self::$builtInFixers = self::builtInFixers(); // @phpstan-ignore-line
        self::$cleanBuiltInFixers = self::builtInFixers(false); // @phpstan-ignore-line
        self::$deprecatedBuiltInFixers = array_diff(self::$builtInFixers, self::$cleanBuiltInFixers); // @phpstan-ignore-line
    }

    public static function tearDownAfterClass(): void
    {
        self::reset();
    }

    final public static function reset(): void
    {
        self::$configured = [];
        self::$builtInFixers = [];
        self::$cleanBuiltInFixers = [];
        self::$deprecatedBuiltInFixers = [];
    }

    /**
     * @codeCoverageIgnore
     *
     * @return iterable
     */
    final public static function ruleNamesProvider(): iterable
    {
        $ruleset = static::createRuleset();
        $name = $ruleset->getName();

        yield $name => [$name, array_keys($ruleset->getRules())];
    }

    protected static function createRuleset(): RulesetInterface
    {
        $className = preg_replace('/^(Nexus\\\\CsConfig)\\\\Tests(\\\\.+)Test$/', '$1$2', static::class);

        return new $className();
    }

    /**
     * Rules defined by PhpCsFixer.
     *
     * @param bool $withDeprecated
     * @param bool $withFixers
     *
     * @return array<string, FixerInterface>|string[]
     */
    private static function builtInFixers(bool $withDeprecated = true, bool $withFixers = false): array
    {
        $fixerFactory = new FixerFactory();
        $fixerFactory->registerBuiltInFixers();
        $fixers = $fixerFactory->getFixers();

        if (! $withDeprecated) {
            $fixers = array_filter($fixers, static function (FixerInterface $fixer): bool {
                return ! $fixer instanceof DeprecatedFixerInterface;
            });
        }

        $builtInFixers = array_map(static function (FixerInterface $fixer): string {
            return $fixer->getName();
        }, $fixers);

        if ($withFixers) {
            return array_combine($builtInFixers, $fixers) ?: [];
        }

        return $builtInFixers;
    }

    /**
     * Rules defined by this ruleset.
     *
     * @return string[]
     */
    private static function configuredFixers(): array
    {
        $rules = array_map(static function ($ruleConfiguration): bool {
            return true;
        }, static::createRuleset()->getRules());

        return array_keys((new RuleSet($rules))->getRules());
    }

    final public function testAllNondeprecatedBuiltInRulesAreConfigured(): void
    {
        $fixersNotConfigured = array_diff(
            self::$cleanBuiltInFixers,
            self::$configured
        );

        sort($fixersNotConfigured);
        $c = \count($fixersNotConfigured);

        self::assertEmpty($fixersNotConfigured, sprintf(
            'Failed asserting that non-deprecated built-in %s "%s" %s configured in "%s" ruleset.',
            $c > 1 ? 'rules' : 'rule',
            implode('", "', $fixersNotConfigured),
            $c > 1 ? 'are' : 'is',
            static::createRuleset()->getName()
        ));
    }

    final public function testAllConfiguredRulesAreBuiltIn(): void
    {
        $fixersNotBuiltIn = array_diff(
            self::$configured,
            self::$cleanBuiltInFixers
        );

        sort($fixersNotBuiltIn);
        $c = \count($fixersNotBuiltIn);

        self::assertEmpty($fixersNotBuiltIn, sprintf(
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

        self::assertSame($sorted, $rules, sprintf(
            'Failed asserting that the rules in "%s" are sorted by name.',
            $source
        ));
    }

    final public function testHeaderCommentFixerIsDisabledByDefault(): void
    {
        $rules = static::createRuleset()->getRules();

        self::assertArrayHasKey('header_comment', $rules);
        self::assertFalse($rules['header_comment']);
    }

    final public function testDeprecatedFixersAreNoLongerUsed(): void
    {
        $rules = array_keys(static::createRuleset()->getRules());

        $rulesWithoutDeprecatedRules = array_filter(
            $rules,
            static function (string $fixer): bool {
                return ! \in_array($fixer, self::$deprecatedBuiltInFixers, true);
            }
        );

        $notRemovedDeprecatedRules = array_diff($rules, $rulesWithoutDeprecatedRules);

        self::assertEmpty($notRemovedDeprecatedRules, sprintf(
            'Failed asserting that deprecated rules "%s" are removed from "%s" ruleset.',
            implode('", "', $notRemovedDeprecatedRules),
            static::createRuleset()->getName()
        ));
    }

    final public function testRulesetDoesNotUseDeprecatedConfigurationOptions(): void
    {
        $ruleset = static::createRuleset();

        $rules = $ruleset->getRules();
        $names = array_keys($rules);
        $fixers = self::builtInFixers(false, true);

        $filtered = array_filter(array_map(static function (string $name, $rule) use ($fixers) {
            if (! \is_array($rule)) {
                return false;
            }

            /** @var FixerInterface $fixer */
            $fixer = $fixers[$name];

            if (! $fixer instanceof ConfigurableFixerInterface) {
                return false;
            }

            $deprecatedConfigurationOptions = array_filter(
                $fixer->getConfigurationDefinition()->getOptions(),
                static function (FixerOptionInterface $option): bool {
                    return $option instanceof DeprecatedFixerOptionInterface;
                }
            );

            $ruleWithDeprecatedOptions = array_intersect(
                array_keys($rule),
                array_map(static function (FixerOptionInterface $option): string {
                    return $option->getName();
                }, $deprecatedConfigurationOptions)
            );

            if ([] !== $ruleWithDeprecatedOptions) {
                return $name;
            }

            return false;
        }, $names, $rules));

        self::assertEmpty($filtered, sprintf(
            'Failed asserting that "%s" ruleset configure its %s "%s" without using %s deprecated configuration options.',
            $ruleset->getName(),
            \count($filtered) > 1 ? 'rules' : 'rule',
            implode('", "', $filtered),
            \count($filtered) > 1 ? 'their' : 'its'
        ));
    }
}
