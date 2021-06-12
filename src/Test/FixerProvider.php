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

namespace Nexus\CsConfig\Test;

use Nexus\CsConfig\Ruleset\RulesetInterface;
use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet\RuleSet;

/**
 * @internal
 */
final class FixerProvider
{
    /**
     * Configured fixers from a ruleset.
     *
     * @var array<int, string>
     */
    private $configured = [];

    /**
     * Built-in fixers from php-cs-fixer.
     *
     * @var array<string, FixerInterface>
     */
    private static $builtIn = [];

    /**
     * @param array<int, string> $configured
     */
    private function __construct(array $configured)
    {
        $this->configured = $configured;
    }

    public static function create(RulesetInterface $ruleset): self
    {
        if ([] === self::$builtIn) {
            $builtIn = array_filter(
                (new FixerFactory())->registerBuiltInFixers()->getFixers(),
                static function (FixerInterface $fixer): bool {
                    return ! $fixer instanceof DeprecatedFixerInterface;
                }
            );
            $names = array_map(static function (FixerInterface $fixer): string {
                return $fixer->getName();
            }, $builtIn);

            self::$builtIn = array_combine($names, $builtIn);
        }

        $configured = array_map(static function ($ruleConfiguration): bool {
            // force enable all rules
            return true;
        }, $ruleset->getRules());

        return new self(array_keys((new RuleSet($configured))->getRules()));
    }

    public static function reset(): void
    {
        self::$builtIn = [];
    }

    public function builtin(): array
    {
        return self::$builtIn;
    }

    /**
     * Returns the names of the configured fixers.
     */
    public function configured(): array
    {
        return $this->configured;
    }
}
