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
 * @category   Tests
 * @package    Alerts
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.90
 * @link       https://inkohsamui.com/
 * @since      11.9.90
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Alerts;

use Booka\Core\Alerts\Types;
use Codeception\Test\Unit;

class TypesTest extends Unit
{
    public function testTypes()
    {

        static::assertSame('success', Types::SUCCESS);
        static::assertSame('danger', Types::DANGER);
        static::assertSame('warning', Types::WARNING);
        static::assertSame('info', Types::INFO);
        static::assertSame('primary', Types::PRIMARY);
        static::assertSame('secondary', Types::SECONDARY);
    }

}
