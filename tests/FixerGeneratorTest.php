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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(FixerGenerator::class)]
final class FixerGeneratorTest extends TestCase
{
    #[DataProvider('provideInvalidParametersThrowRuntimeExceptionCases')]
    public function testInvalidParametersThrowRuntimeException(string $path, string $vendor, string $message): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage($message);
        FixerGenerator::create($path, $vendor);
    }

    /**
     * @return iterable<string, string[]>
     */
    public static function provideInvalidParametersThrowRuntimeExceptionCases(): iterable
    {
        yield 'empty-path' => ['', 'Nexus', 'Path to custom fixers cannot be empty.'];

        yield 'path-not-dir' => ['foo', 'Nexus', 'Path "foo" is not a valid directory.'];

        yield 'path-is-file' => [__FILE__, 'Nexus', sprintf('Path "%s" is not a valid directory.', __FILE__)];

        yield 'empty-vendor' => [__DIR__, '', 'Vendor namespace cannot be empty.'];

        yield 'invalid-vendor' => [__DIR__, 'Nexus()', 'Vendor namespace "Nexus()" is not valid.'];
    }

    public function testTraversableReturnedAreInstancesOfFixerInterface(): void
    {
        $generator = FixerGenerator::create('vendor/friendsofphp/php-cs-fixer/src/Fixer', 'PhpCsFixer\\Fixer');
        self::assertNotEmpty(iterator_to_array($generator));
    }
}
