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

use Nexus\CsConfig\Ruleset\Nexus73;
use Nexus\CsConfig\Ruleset\RulesetInterface;
use Nexus\CsConfig\Test\FixerProvider;
use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Nexus\CsConfig\Test\FixerProvider
 */
final class FixerProviderTest extends TestCase
{
    protected function setUp(): void
    {
        FixerProvider::reset();
    }

    public function testCreateMethodCreatesSameBuiltInFixers(): void
    {
        $fixerProvider1 = FixerProvider::create($this->mockRuleset());
        $fixerProvider2 = FixerProvider::create($this->mockRuleset());

        self::assertSame($fixerProvider1->builtin(), $fixerProvider2->builtin());
    }

    /**
     * @dataProvider provideBuiltinFixersCases
     */
    public function testCreateMethodGivesNoDeprecatedBuiltInFixers(FixerInterface $fixer): void
    {
        self::assertNotInstanceOf(DeprecatedFixerInterface::class, $fixer);
    }

    public function provideBuiltinFixersCases(): iterable
    {
        $builtin = FixerProvider::create($this->mockRuleset())->builtin();
        ksort($builtin, SORT_REGULAR);

        foreach ($builtin as $name => $fixer) {
            yield $name => [$fixer];
        }
    }

    public function testResetReallyResetsBuiltIn(): void
    {
        $provider = FixerProvider::create($this->mockRuleset());
        self::assertNotEmpty($provider->builtin());

        FixerProvider::reset();
        self::assertEmpty($provider->builtin());
    }

    public function testCreateMethodGivesConfiguredRulesAllEnabled(): void
    {
        $provider = FixerProvider::create(new Nexus73());
        $configured = $provider->configured();
        $builtin = $provider->builtin();
        $enabled = array_filter((new Nexus73())->getRules());

        self::assertSame(\count($builtin), \count($configured));
        self::assertLessThan(\count($configured), \count($enabled));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject&\Nexus\CsConfig\Ruleset\RulesetInterface
     */
    private function mockRuleset()
    {
        return $this->createMock(RulesetInterface::class);
    }
}
