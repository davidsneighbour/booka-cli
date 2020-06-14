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
 * @since      11.7.110
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Users;

use Booka\Core\Users\Avatar;
use Codeception\Test\Unit;

/**
 * Class AvatarTest
 *
 * @package Booka\Testing\Unit\Users
 */
class AvatarTest extends Unit
{

    public function testCreate()
    {

        $avatar = Avatar::create('user', 666);
        static::assertIsBool($avatar);
        static::assertTrue($avatar);
    }

    public function testGet()
    {

        $avatar = Avatar::get('customer', 13);
        static::assertIsString($avatar);
        $avatar = Avatar::get('user', 666);
        static::assertIsString($avatar);

        $avatar = Avatar::get('unknown', 123);
        $defaultAvatar = '/theme/assets/images/default-avatar.jpg';
        static::assertIsString($avatar);
        static::assertSame($defaultAvatar, $avatar);
    }
}
