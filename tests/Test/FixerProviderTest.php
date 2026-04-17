<?php

declare(strict_types=1);

/**
 * This file is part of Nexus CS Config.
 *
 * (c) 2020 John Paul E. Balandan, CPA <paulbalandan@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Nexus\CsConfig\Tests\Test;

use Nexus\CsConfig\Ruleset\Nexus82;
use Nexus\CsConfig\Ruleset\RulesetInterface;
use Nexus\CsConfig\Test\FixerProvider;
use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(FixerProvider::class)]
final class FixerProviderTest extends TestCase
{
    protected function setUp(): void
    {
        FixerProvider::reset();
    }

    public function testCreateMethodCreatesSameBuiltInFixers(): void
    {
        $fixerProvider1 = FixerProvider::create(self::mockRuleset());
        $fixerProvider2 = FixerProvider::create(self::mockRuleset());

        self::assertSame($fixerProvider1->builtin(), $fixerProvider2->builtin());
    }

    #[DataProvider('provideCreateMethodGivesNoDeprecatedBuiltInFixersCases')]
    public function testCreateMethodGivesNoDeprecatedBuiltInFixers(FixerInterface $fixer): void
    {
        self::assertNotInstanceOf(DeprecatedFixerInterface::class, $fixer);
    }

    /**
     * @return iterable<string, array{FixerInterface}>
     */
    public static function provideCreateMethodGivesNoDeprecatedBuiltInFixersCases(): iterable
    {
        $builtin = FixerProvider::create(new Nexus82())->builtin();
        ksort($builtin, \SORT_REGULAR);

        foreach ($builtin as $name => $fixer) {
            yield $name => [$fixer];
        }
    }

    public function testResetReallyResetsBuiltIn(): void
    {
        $provider = FixerProvider::create(self::mockRuleset());
        self::assertNotEmpty($provider->builtin());

        FixerProvider::reset();
        self::assertEmpty($provider->builtin());
    }

    public function testCreateMethodGivesConfiguredRulesAllEnabled(): void
    {
        $provider = FixerProvider::create(new Nexus82());
        $configured = $provider->configured();
        $builtin = $provider->builtin();
        $enabled = array_filter(
            (new Nexus82())->getRules(),
            static fn(mixed $value): bool => false !== $value,
        );

        self::assertCount(\count($builtin), $configured);
        self::assertLessThan(\count($configured), \count($enabled));
    }

    public function testEnabledMethodPassesSameRulesAsCallingRulesetRulesDirectly(): void
    {
        $enabledByProvider = FixerProvider::create(new Nexus82())->enabled();
        $enabledByRuleset = (new Nexus82())->getRules();

        self::assertSame($enabledByRuleset, $enabledByProvider);
    }

    private static function mockRuleset(): RulesetInterface&Stub
    {
        return self::createStub(RulesetInterface::class);
    }
}
