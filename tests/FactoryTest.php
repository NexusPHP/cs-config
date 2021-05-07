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

namespace Nexus\CsConfig\Tests;

use Nexus\CsConfig\Factory;
use Nexus\CsConfig\Ruleset\Nexus73;
use Nexus\CsConfig\Ruleset\RulesetInterface;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FactoryTest extends TestCase
{
    public function testFactoryThrowsExceptionOnIncompatibleVersionId(): void
    {
        $ruleset = $this->mockRuleset();
        $ruleset
            ->method('getRequiredPHPVersion')
            ->willReturn(\PHP_VERSION_ID + 2)
        ;

        $this->expectException('RuntimeException');
        $this->expectExceptionMessage(sprintf(
            'The "%s" ruleset requires a minimum PHP_VERSION_ID of "%d" but current PHP_VERSION_ID is "%d".',
            $ruleset->getName(),
            $ruleset->getRequiredPHPVersion(),
            \PHP_VERSION_ID
        ));
        Factory::create($ruleset);
    }

    public function testFactoryReturnsInstanceOfConfig(): void
    {
        $config = Factory::create($this->mockRuleset())->forProjects();
        self::assertInstanceOf(Config::class, $config);

        $config = Factory::create($this->mockRuleset())->forLibrary('Library', 'John Doe', 'email', 2020);
        self::assertInstanceOf(Config::class, $config);
    }

    public function testFactoryPassesSameRulesFromRuleset(): void
    {
        $ruleset = $this->mockRuleset();
        $config = Factory::create($ruleset)->forProjects();

        self::assertSame($ruleset->getRules(), $config->getRules());
    }

    public function testFactoryAllowsOverrideOfRules(): void
    {
        $config = Factory::create(new Nexus73())->forProjects();
        self::assertIsArray($config->getRules()['binary_operator_spaces']);

        $config = Factory::create(new Nexus73(), [
            'binary_operator_spaces' => false,
        ])->forProjects();
        self::assertFalse($config->getRules()['binary_operator_spaces']);
    }

    public function testFactoryReturnsDefaultOptionsWhenNoOptionsGiven(): void
    {
        $config = Factory::create($this->mockRuleset())->forProjects();

        self::assertSame('.php-cs-fixer.cache', $config->getCacheFile());
        self::assertSame([], $config->getCustomFixers());
        self::assertInstanceOf(Finder::class, $config->getFinder());
        self::assertSame('txt', $config->getFormat());
        self::assertFalse($config->getHideProgress());
        self::assertSame('    ', $config->getIndent());
        self::assertSame("\n", $config->getLineEnding());
        self::assertNull($config->getPhpExecutable());
        self::assertIsBool($config->getRiskyAllowed());
        self::assertTrue($config->getUsingCache());
    }

    public function testFactoryConsumesPassedOptionsToIt(): void
    {
        $options = [
            'cacheFile' => __DIR__ . '/../../build/.php-cs-fixer.cache',
            'format' => 'junit',
            'hideProgress' => true,
            'indent' => "\t",
            'lineEnding' => "\r\n",
            'phpExecutable' => PHP_BINARY,
            'usingCache' => false,
        ];
        $config = Factory::create($this->mockRuleset(), [], $options)->forProjects();

        self::assertSame($options['cacheFile'], $config->getCacheFile());
        self::assertSame($options['format'], $config->getFormat());
        self::assertTrue($config->getHideProgress());
        self::assertSame($options['indent'], $config->getIndent());
        self::assertSame($options['lineEnding'], $config->getLineEnding());
        self::assertSame($options['phpExecutable'], $config->getPhpExecutable());
        self::assertFalse($config->getUsingCache());
    }

    public function testCreateForLibraryCreatesPreformattedLicense(): void
    {
        $config = Factory::create($this->mockRuleset())->forLibrary('Library', 'Foo Bar', 'foo@bar.com', 2020);
        $header = $config->getRules()['header_comment']['header'];

        self::assertStringContainsString('This file is part of Library.', $header);
        self::assertStringContainsString('(c) 2020 Foo Bar <foo@bar.com>', $header);
    }

    /** @return \PHPUnit\Framework\MockObject\MockObject&\Nexus\CsConfig\Ruleset\RulesetInterface */
    private function mockRuleset()
    {
        return $this->createMock(RulesetInterface::class);
    }
}
