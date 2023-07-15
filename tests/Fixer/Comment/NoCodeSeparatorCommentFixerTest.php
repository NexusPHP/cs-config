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

use Nexus\CsConfig\Test\AbstractCustomFixerTestCase;

/**
 * @internal
 *
 * @covers \Nexus\CsConfig\Fixer\AbstractCustomFixer
 * @covers \Nexus\CsConfig\Fixer\Comment\NoCodeSeparatorCommentFixer
 * @covers \Nexus\CsConfig\Test\AbstractCustomFixerTestCase
 */
final class NoCodeSeparatorCommentFixerTest extends AbstractCustomFixerTestCase
{
    public static function provideFixCases(): iterable
    {
        yield [
            '<?php

            $a = [];
            ',
            '<?php

            //---------------------
            $a = [];
            ',
        ];

        yield [
            '<?php

            // - a comment
            $arr = [];
            ',
        ];

        yield [
            '<?php

            //=======================
            // A Section
            //=======================

            $a = 1;

            $b = 2;
            ',
            '<?php

            //=======================
            // A Section
            //=======================

            $a = 1;

            //-----------------------

            $b = 2;
            ',
        ];
    }

    /**
     * @dataProvider provideFixCases
     */
    public function testFix(string $expected, ?string $input = null): void
    {
        $this->doTest($expected, $input);
    }
}
