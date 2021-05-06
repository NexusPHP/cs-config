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
use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet\RuleSet;
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
        $name = $ruleset->getName();

        yield $name => [$name, array_keys($ruleset->getRules())];
    }

    /**
     * @codeCoverageIgnore
     *
     * @return iterable
     */
    public static function deprecatedBuiltInFixersProvider(): iterable
    {
        static $deprecatedFixers;

        if (null === $deprecatedFixers) {
            $fixerFactory = new FixerFactory();
            $fixerFactory->registerBuiltInFixers();

            $deprecatedFixers = array_map(static function (FixerInterface $fixer): string {
                return $fixer->getName();
            }, array_filter($fixerFactory->getFixers(), static function (FixerInterface $fixer): bool {
                return $fixer instanceof DeprecatedFixerInterface;
            }));

            sort($deprecatedFixers);
        }

        foreach ($deprecatedFixers as $fixer) {
            yield $fixer => [$fixer];
        }
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

    final public function testAllBuiltInRulesAreConfigured(): void
    {
        $fixersWithoutConfiguration = array_diff(
            $this->builtInFixers(),
            $this->configuredFixers()
        );

        sort($fixersWithoutConfiguration);
        $c = \count($fixersWithoutConfiguration);

        self::assertEmpty($fixersWithoutConfiguration, sprintf(
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

        self::assertArrayHasKey('header_comment', $rules);
        self::assertFalse($rules['header_comment']);
    }

    /**
     * @dataProvider deprecatedBuiltInFixersProvider
     *
     * @param string $fixer
     *
     * @return void
     */
    final public function testDeprecatedFixersAreTurnedOff(string $fixer): void
    {
        static $rules;

        if (null === $rules) {
            $rules = self::createRuleset()->getRules();
        }

        self::assertArrayHasKey($fixer, $rules);
        self::assertFalse($rules[$fixer], sprintf(
            'Failed asserting that the deprecated "%s" fixer is set to false.',
            $fixer
        ));
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
            $fixerFactory = new FixerFactory();
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

        return array_keys((new RuleSet($rules))->getRules());
    }
}
