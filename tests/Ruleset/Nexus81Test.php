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

namespace Nexus\CsConfig\Tests\Ruleset;

use Nexus\CsConfig\Ruleset\AbstractRuleset;
use Nexus\CsConfig\Ruleset\Nexus81;
use Nexus\CsConfig\Test\AbstractRulesetTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * @internal
 */
#[CoversClass(AbstractRuleset::class)]
#[CoversClass(Nexus81::class)]
#[CoversClass(AbstractRulesetTestCase::class)]
final class Nexus81Test extends AbstractRulesetTestCase {}
