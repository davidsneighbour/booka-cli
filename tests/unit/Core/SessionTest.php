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
 * @version    11.9.90
 * @link       https://inkohsamui.com/
 * @since      11.9.90
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Core;

use Booka\Core\Session;
use Codeception\Test\Unit;

use const PHP_SESSION_ACTIVE;

/**
 * Class SessionTest
 *
 * @package Booka\Testing\Unit
 */
class SessionTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testGet()
    {
    }

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testForget()
    {
    }

    public function testGetInstance()
    {

        // no session exists
        $aSession = Session::getInstance();
        static::assertSame([], $aSession);
    }

    /**
     * @depends testGetInstance
     */
    public function testPut()
    {

        // check session
        Session::put('test', 'bla');

        // check if session has value
        $aSession = Session::getInstance();
        static::assertCount(1, $aSession);
        static::assertSame('bla', $aSession['test']);
    }

    protected function _after()
    {

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    protected function _before()
    {

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        session_start();
    }
}
