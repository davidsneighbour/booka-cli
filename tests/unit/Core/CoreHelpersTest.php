<?php

/**
 * BooKa 13
 *
 * Copyright (c) 2007-2018 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 7.4
 *
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  All rights reserved. 2007-2018 - David's Neighbour Part., Ltd.
 * @license    license.txt
 * @package    tests
 * @since      11.7.123
 * @version    11.9.65
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Core;

use Booka\Core\Helpers\Helpers;
use Booka\Core\Transformers\TransformerBool;
use Codeception\Test\Unit;

/**
 * Class CoreHelpersTest
 *
 * @coversDefaultClass \Booka\Core\Helpers\Helpers
 */
class CoreHelpersTest extends Unit
{

    protected $tester;

    /**
     * @covers ::slugify()
     * @throws \Booka\Core\Exception
     */
    public function testSlugify()
    {

        self::assertEquals(
            'test-14',
            Helpers::slugify('Test 14 ')
        );
        self::assertEquals(
            'kbr-srt',
            Helpers::slugify(' KBR - SRT ')
        );
        self::assertEquals('n-a', Helpers::slugify(' - -- '));
        self::assertEquals(
            '7-11-ptt-hua-thanon-3-12am',
            Helpers::slugify(
                '7/11 PTT Hua Thanon / เซเว่นอีเล่เว่น พีทีทีหัวถนน - 3:12am'
            )
        );
    }

    /**
     * @todo move to transformerbool test
     */
    public function testBooleanize()
    {

        self::assertTrue(TransformerBool::create('1'));
        self::assertTrue(TransformerBool::create('true'));
        self::assertTrue(TransformerBool::create('yes'));
        self::assertTrue(TransformerBool::create('on'));
        self::assertTrue(TransformerBool::create(true));
    }
}
