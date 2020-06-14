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

namespace unit;

use Booka\Core\Validation;
use Codeception\Test\Unit;

/**
 * Class CoreValidationTest
 *
 * @coversDefaultClass \Booka\Core\Validation
 */
class CoreValidationTest extends Unit
{

    /**
     * @covers ::isDate()
     */
    public function testIsDate()
    {

        self::assertTrue(Validation::isDate('2018-12-30'));
        self::assertFalse(Validation::isDate('2018-02-29'));
        self::assertFalse(Validation::isDate('April 15th 2019'));
        self::assertFalse(Validation::isDate('100-31-10'));
    }
}
