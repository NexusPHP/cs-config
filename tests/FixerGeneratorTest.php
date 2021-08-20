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

namespace Nexus\CsConfig\Tests;

use Nexus\CsConfig\FixerGenerator;
use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Nexus\CsConfig\FixerGenerator
 */
final class FixerGeneratorTest extends TestCase
{
    /**
     * @dataProvider provideInvalidParametersCases
     */
    public function testInvalidParametersThrowRuntimeException(string $path, string $vendor): void
    {
        $this->expectException(\RuntimeException::class);
        FixerGenerator::create($path, $vendor);
    }

    /**
     * @return iterable<string, string[]>
     */
    public function provideInvalidParametersCases(): iterable
    {
        yield 'empty-path' => ['', 'Nexus'];

        yield 'path-not-dir' => ['foo', 'Nexus'];

        yield 'path-is-file' => [__FILE__, 'Nexus'];

        yield 'empty-vendor' => [__DIR__, ''];

        yield 'invalid-vendor' => [__DIR__, 'Nexus()'];
    }

    public function testCreateMethodReturnsSelf(): void
    {
        self::assertInstanceOf(FixerGenerator::class, FixerGenerator::create(
            'vendor/friendsofphp/php-cs-fixer/src/Fixer',
            'PhpCsFixer\\Fixer\\',
        ));
    }

    public function testTraversableReturnedAreInstancesOfFixerInterface(): void
    {
        $generator = FixerGenerator::create('vendor/friendsofphp/php-cs-fixer/src/Fixer', 'PhpCsFixer\\Fixer');

        foreach ($generator as $fixer) {
            self::assertInstanceOf(FixerInterface::class, $fixer);
        }
    }
}
