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
 * @category   NEW
 * @package    NEW
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    NEW
 * @link       https://inkohsamui.com/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Core\Options;

use Booka\Core\Options\UserOptions;
use Booka\Core\Options\OptionTypes;
use Codeception\Test\Unit;

class UserOptionsTest extends Unit
{

    public function testClass()
    {
        $this->assertSame(OptionTypes::USER, UserOptions::$type);
    }

}
