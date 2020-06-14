<?php

/**
 * BooKa 13
 *
 * Copyright (c) 2007-2018 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 7.4
 *
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  All rights reserved. 2007-2018 - David's Neighbour Part., Ltd.
 * @license    license.txt
 * @package    tests
 * @since      11.7.123
 * @version    11.9.65
 * @filesource
 */

declare(strict_types=1);

namespace unit;

use Booka\Core\Constants;
use Codeception\Test\Unit;

use function codecept_debug;

/**
 * @coversNothing
 */
class SystemSetupTest extends Unit
{

    /**
     * @coversNothing
     */
    public function testDynamicCreatedFilesAndDirectories()
    {

        $paths = file(
            __DIR__ . '/filesystem-checks.txt',
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );
        //codecept_debug($paths);
        foreach ($paths as $path) {
            static::assertFileExists(
                Constants::getString('ROOTDIR') . '/' . $path
            );
            static::assertFileIsReadable(
                Constants::getString('ROOTDIR') . '/' . $path
            );
        }
    }
}
