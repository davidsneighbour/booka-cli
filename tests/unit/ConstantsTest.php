<?php

/**
 * BooKa 13
 *
 * Copyright (c) 2007-2020 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 7.4
 *
 * @category   Modules|Api|Core
 * @package    Users
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.65
 * @link       https://inkohsamui.com/
 * @since      11.7.123
 * @filesource
 */

declare(strict_types=1);

namespace unit;

use Booka\Core\Constants;
use Codeception\Test\Unit;

/**
 * Class ConstantsTest
 *
 * @coversDefaultClass Booka\Core\Constants
 */
class ConstantsTest extends Unit
{

    public function testGet()
    {

        $this->assertIsString(Constants::get('ROOTDIR'));
        $this->assertIsBool(Constants::get('NONEXISTING'));
    }
}
