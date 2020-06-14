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

namespace Booka\Testing\Api\Core;

use ApiTester;
use Codeception\Util\HttpCode;

/**
 * Testing \Booka\Api\Core\Ping
 */
class TestPingCest
{

    /**
     * Tests, if POST to /ping results in code 201
     *
     * @param ApiTester $tester
     */
    public function ping(ApiTester $tester)
    {

        $tester->sendPOST('/ping');
        $tester->seeResponseCodeIs(HttpCode::CREATED);
        //$tester->seeResponseContains('true');
    }
}
