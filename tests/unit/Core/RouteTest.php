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
 * @version    NEW
 * @link       https://inkohsamui.com/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Core;

use Booka\Core\Route;
use Codeception\Test\Unit;

/**
 * Class RouteTest
 *
 * @package Booka\Testing\Unit\Core
 */
class RouteTest extends Unit
{

    public function testGetSubDo()
    {

        $test = Route::getSubDo();
        static::assertIsString($test);
        static::assertSame('subdostring', $test);
    }

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testSetInstance()
    {
    }

    public function testGetModule()
    {

        $test = Route::getModule();
        static::assertIsString($test);
        static::assertSame('modulestring', $test);
    }

    public function testGetSubId()
    {

        $test = Route::getSubId();
        static::assertIsInt($test);
        static::assertSame(200, $test);
    }

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetInstance()
    {
    }

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetRouteString()
    {
    }

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetRoute()
    {
    }

    public function testGetDo()
    {

        $test = Route::getDo();
        static::assertIsString($test);
        static::assertSame('dostring', $test);
    }

    public function testGetAction()
    {

        $test = Route::getAction();
        static::assertIsString($test);
        static::assertSame('actionstring', $test);
    }

    public function testGetId()
    {

        $test = Route::getId();
        static::assertIsInt($test);
        static::assertSame(100, $test);
    }

    protected function _before()
    {

        Route::setInstance(
            [
                'module' => 'modulestring',
                'action' => 'actionstring',
                'id'     => 100,
                'do'     => 'dostring',
                'subid'  => 200,
                'subdo'  => 'subdostring',
            ]
        );
    }
}
