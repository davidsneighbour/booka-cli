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

use Booka\Core\Users\Userrole;
use Codeception\Test\Unit;

/**
 * Class UserroleTest
 */
class UserroleTest extends Unit
{

    public function testAdministrator()
    {

        static::assertIsInt(Userrole::ADMINISTRATOR()->getValue());
        static::assertSame(1000, Userrole::ADMINISTRATOR()->getValue());
        static::assertSame(Userrole::getEnumLabel(1000), 'Administrator');
    }

    public function testOwner()
    {

        static::assertIsInt(Userrole::OWNER()->getValue());
        static::assertSame(2000, Userrole::OWNER()->getValue());
        static::assertSame(Userrole::getEnumLabel(2000), 'Owner');
    }

    public function testManager()
    {

        static::assertIsInt(Userrole::MANAGER()->getValue());
        static::assertSame(2500, Userrole::MANAGER()->getValue());
        static::assertSame(Userrole::getEnumLabel(2500), 'Manager');
    }

    public function testBooker()
    {

        static::assertIsInt(Userrole::BOOKER()->getValue());
        static::assertSame(3000, Userrole::BOOKER()->getValue());
        static::assertSame(Userrole::getEnumLabel(3000), 'Booker');
    }

    public function testAgentadmin()
    {

        static::assertIsInt(Userrole::AGENTADMIN()->getValue());
        static::assertSame(4000, Userrole::AGENTADMIN()->getValue());
        static::assertSame(Userrole::getEnumLabel(4000), 'Agentadmin');
    }

    public function testAgent()
    {

        static::assertIsInt(Userrole::AGENT()->getValue());
        static::assertSame(5000, Userrole::AGENT()->getValue());
        static::assertSame(Userrole::getEnumLabel(5000), 'Agent');
    }

    public function testGuide()
    {

        static::assertIsInt(Userrole::GUIDE()->getValue());
        static::assertSame(6000, Userrole::GUIDE()->getValue());
        static::assertSame(Userrole::getEnumLabel(6000), 'Guide');
    }

    public function testDriver()
    {

        static::assertIsInt(Userrole::DRIVER()->getValue());
        static::assertSame(7000, Userrole::DRIVER()->getValue());
        static::assertSame(Userrole::getEnumLabel(7000), 'Driver');
    }

    public function testPublic()
    {

        static::assertIsInt(Userrole::PUBLIC()->getValue());
        static::assertSame(9000, Userrole::PUBLIC()->getValue());
        static::assertSame(Userrole::getEnumLabel(9000), 'Guest');

        static::assertIsInt(Userrole::guest()->getValue());
        static::assertSame(9000, Userrole::guest()->getValue());
        static::assertSame(Userrole::getEnumLabel(9000), 'Guest');
    }

}
