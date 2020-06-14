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

namespace Booka\Testing\Unit\Core;

use Booka\Core\Paths;
use Codeception\Test\Unit;

/**
 * Class PathsTest
 */
class PathsTest extends Unit
{

    public function testGetCacheDir()
    {

        $path = Paths::getCacheDir();
        static::assertIsString($path);
        static::assertDirectoryExists($path);

        $path2 = Paths::getCacheDir('bla');
        static::assertIsString($path2);
        static::assertSame($path . 'bla', $path2);
    }

    public function testGetFileDir()
    {

        $path = Paths::getFileDir();
        static::assertIsString($path);
        static::assertDirectoryExists($path);

        $path2 = Paths::getFileDir('bla');
        static::assertIsString($path2);
        static::assertSame($path . 'bla', $path2);
    }

    public function testGetFileUri()
    {

        $path = Paths::getFileUri();
        static::assertIsString($path);
    }

    protected function _after()
    {

        $path = Paths::getCacheDir();
        $sPathToRemove = realpath($path) . '/bla';
        if (is_dir($sPathToRemove)) {
            rmdir($sPathToRemove);
        }
    }
}
