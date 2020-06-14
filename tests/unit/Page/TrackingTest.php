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

namespace Booka\Testing\Unit\Page;

use Booka\Core\Configuration\Config;
use Booka\Core\Page\Tracking;
use Codeception\Test\Unit;

/**
 * Class TrackingTest
 *
 * @coversDefaultClass Booka\Core\Page\Tracking
 */
class TrackingTest extends Unit
{

    /**
     * @covers ::hasLogrocket()
     * @throws \Exception
     */
    public function testLogrocket()
    {

        foreach ([true, false] as $value) {
            $this->make(
                Config::class,
                [
                    'isLocal'       => $value,
                    'forceTracking' => $value,
                ]
            );

            self::assertTrue(
                Tracking::hasLogrocket() === Config::get('forceTracking')
            );
        }
    }

    /**
     * @covers ::hasSentry()
     * @throws \Exception
     * @doesNotPerformAssertions (remove later)
     */
    public function testSentry()
    {

//        foreach ([true, false] as $value) {
//            $this->make(
//                Config::class,
//                [
//                    'isLocal' => $value,
//                ]
//            );
//
//            self::assertTrue(
//                Tracking::hasSentry() !== Config::get('isLocal')
//            );
//        }

//        $this->make(
//            Settings::class,
//            [
//                'sentry_enabled_javascript' => true,
//            ]
//        );
//        self::assertTrue(Tracking::hasSentry() == Settings::getString('sentry_enabled_javascript'));
    }

}
