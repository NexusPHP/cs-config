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

namespace Nexus\CsConfig\Ruleset;

abstract class AbstractRuleset implements RulesetInterface
{
    /**
     * Name of the ruleset.
     *
     * @var string
     */
    protected $name = '';

    /**
     * Rules for the ruleset.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Minimum PHP version.
     *
     * @var int
     */
    protected $requiredPHPVersion = 0;

    /**
     * Have this ruleset turn on `$isRiskyAllowed` flag?
     *
     * @var bool
     */
    protected $autoActivateIsRiskyAllowed = false;

    /**
     * {@inheritdoc}
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    final public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * {@inheritdoc}
     */
    final public function getRequiredPHPVersion(): int
    {
        return $this->requiredPHPVersion;
    }

    /**
     * {@inheritdoc}
     */
    final public function willAutoActivateIsRiskyAllowed(): bool
    {
        return $this->autoActivateIsRiskyAllowed;
    }
}
