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

namespace Nexus\CsConfig\Tests\Fixer\Comment;

use Nexus\CsConfig\Fixer\AbstractCustomFixer;
use Nexus\CsConfig\Fixer\Comment\NoCodeSeparatorCommentFixer;
use Nexus\CsConfig\Test\AbstractCustomFixerTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @internal
 */
#[CoversClass(AbstractCustomFixer::class)]
#[CoversClass(NoCodeSeparatorCommentFixer::class)]
#[CoversClass(AbstractCustomFixerTestCase::class)]
final class NoCodeSeparatorCommentFixerTest extends AbstractCustomFixerTestCase
{
    #[DataProvider('provideFixCases')]
    public function testFix(string $expected, ?string $input = null): void
    {
        $this->doTest($expected, $input);
    }

    public static function provideFixCases(): iterable
    {
        yield [
            <<<'EOD'
                <?php

                $a = [];

                EOD,
            <<<'EOD'
                <?php

                //---------------------
                $a = [];

                EOD,
        ];

        yield [
            <<<'EOD'
                <?php

                // - a comment
                $arr = [];

                EOD,
        ];

        yield [
            <<<'EOD'
                <?php

                //=======================
                // A Section
                //=======================

                $a = 1;

                $b = 2;

                EOD,
            <<<'EOD'
                <?php

                //=======================
                // A Section
                //=======================

                $a = 1;

                //-----------------------

                $b = 2;

                EOD,
        ];
    }
}
