<?php
/** @noinspection PhpMultipleClassesDeclarationsInOneFile */

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

namespace Booka\Testing\Unit;

use Booka\Core\Psr4AutoloaderClass;
use Codeception\Test\Unit;
use Safe\Exceptions\StringsException;

/**
 * Class MockPsr4AutoloaderClass
 *
 * @coversDefaultClass \Booka\Core\Psr4AutoloaderClass
 */
class MockPsr4AutoloaderClass extends Psr4AutoloaderClass
{

    /**
     * @var array
     */
    protected array $files = [];

    /**
     * @param array $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    /**
     * if a file exists, require it from the file system.
     *
     * @param string $file the file to require.
     *
     * @return bool true if the file exists, false if not.
     */
    protected function requireFile($file)
    {
        return in_array($file, $this->files);
    }

}

/**
 * Class Psr4AutoloaderClassTest
 *
 * @coversDefaultClass \Booka\Core\Psr4AutoloaderClass
 */
class Psr4AutoloaderClassTest extends Unit
{

    /**
     * @var MockPsr4AutoloaderClass $loader
     */
    protected MockPsr4AutoloaderClass $loader;

    /**
     * @throws StringsException
     */
    public function testExistingFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\ClassName');
        $expect = '/vendor/foo.bar/src/ClassName.php';
        self::assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\Bar\ClassNameTest');
        $expect = '/vendor/foo.bar/tests/ClassNameTest.php';
        self::assertSame($expect, $actual);
    }

    /**
     * @throws StringsException
     */
    public function testMissingFile()
    {
        $actual = $this->loader->loadClass('No_Vendor\No_Package\NoClass');
        self::assertFalse($actual);
    }

    /**
     * @throws StringsException
     */
    public function testDeepFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\Baz\Dib\Zim\Gir\ClassName');
        $expect = '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php';
        self::assertSame($expect, $actual);
    }

    /**
     * @throws StringsException
     */
    public function testConfusion()
    {
        $actual = $this->loader->loadClass('Foo\Bar\DoomClassName');
        $expect = '/vendor/foo.bar/src/DoomClassName.php';
        self::assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\BarDoom\ClassName');
        $expect = '/vendor/foo.bardoom/src/ClassName.php';
        self::assertSame($expect, $actual);
    }

    /**
     * @covers ::addNamespace
     */
    protected function setUp(): void
    {
        $this->loader = new MockPsr4AutoloaderClass();

        $this->loader->setFiles(
            [
                '/vendor/foo.bar/src/ClassName.php',
                '/vendor/foo.bar/src/DoomClassName.php',
                '/vendor/foo.bar/tests/ClassNameTest.php',
                '/vendor/foo.bardoom/src/ClassName.php',
                '/vendor/foo.bar.baz.dib/src/ClassName.php',
                '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php',
            ]
        );

        $this->loader->addNamespace(
            'Foo\Bar',
            '/vendor/foo.bar/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar',
            '/vendor/foo.bar/tests'
        );

        $this->loader->addNamespace(
            'Foo\BarDoom',
            '/vendor/foo.bardoom/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar\Baz\Dib',
            '/vendor/foo.bar.baz.dib/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar\Baz\Dib\Zim\Gir',
            '/vendor/foo.bar.baz.dib.zim.gir/src',
            true
        );
    }

}
