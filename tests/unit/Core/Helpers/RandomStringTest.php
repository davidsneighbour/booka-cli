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

namespace Booka\Testing\Unit\Core\Helpers;

use Booka\Core\Helpers\RandomString;
use Codeception\Test\Unit;

/**
 * Class RandomStringTest
 *
 * @coversDefaultClass Booka\Core\Helpers\RandomString
 */
class RandomStringTest extends Unit
{

    /**
     * @covers ::get()
     * @throws \Exception
     */
    public function testRandomString()
    {

        for ($iCounter = 0; $iCounter < random_int(15, 50); $iCounter++) {
            $iLength = random_int(10, 40) * 2;
            $sHash = RandomString::get($iLength);

            self::assertTrue(is_string($sHash));

            //codecept_debug($iLength);
            //codecept_debug($sHash);
            //codecept_debug(strlen($sHash));

            self::assertTrue(strlen($sHash) === $iLength);
        }
    }

}
