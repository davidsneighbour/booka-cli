<?php /** @noinspection PhpUndefinedMethodInspection */

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
 * @version    11.9.92
 * @link       https://inkohsamui.com/
 * @since      11.9.92
 * @filesource
 */

//declare(strict_types=1);
//
//namespace Booka\Testing\Unit\Core\Traits;
//
//use Booka\Core\Traits\TypedGet;
//use Codeception\Test\Unit;
//
///**
// * Class TypedGetTest
// *
// * @package Booka\Test\Unit\Core\Traits
// */
//class TypedGetTest extends Unit
//{
//    /**
//     */
//    public function testGetFloat()
//    {
//
//        $mock = $this->getMockForTrait(TypedGet::class);
//
//        static::assertIsFloat($mock->getFloat(1.1));
//        static::assertSame(0.0, $mock->getFloat('string'));
//    }
//
//    /**
//     */
//    public function testGetInt()
//    {
//
//        $mock = $this->getMockForTrait(TypedGet::class);
//        static::assertIsInt($mock->getInt(1));
//        static::assertIsInt($mock->getInt('1'));
//        static::assertIsInt($mock->getInt('string'));
//        static::assertSame(0, $mock->getInt('string'));
//    }
//
//    /**
//     */
//    public function testGetString()
//    {
//
//        $mock = $this->getMockForTrait(TypedGet::class);
//        static::assertIsString($mock->getString(1));
//        static::assertIsString($mock->getString('1'));
//        static::assertIsString($mock->getString('string'));
//        static::assertSame('1', $mock->getString(1));
//    }
//
//    /**
//     */
//    public function testGetBool()
//    {
//
//        $mock = $this->getMockForTrait(TypedGet::class);
//        static::assertIsBool($mock->getBool(1));
//        static::assertIsBool($mock->getBool(0));
//        static::assertIsBool($mock->getBool('1'));
//        static::assertIsBool($mock->getBool('0'));
//        static::assertSame(true, $mock->getBool(1));
//        static::assertSame(true, $mock->getBool('1'));
//        static::assertSame(true, $mock->getBool('bla'));
//    }
//
//    /**
//     * @doesNotPerformAssertions (remove later)
//     */
//    public function testGetArray()
//    {
//    }
//}
