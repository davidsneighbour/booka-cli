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

namespace Booka\Testing\Unit\Tours;

use Booka\Tours\Prices2;
use Codeception\Test\Unit;

class Prices2Test extends Unit
{

    /**
     * @covers \Booka\Tours\Prices2::getSeat()
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetSeat()
    {
    }

    /**
     * @covers \Booka\Tours\Prices2::cleanupItems()
     * @doesNotPerformAssertions (remove later)
     */
    public function testCleanupItems()
    {
    }

    /**
     * @covers \Booka\Tours\Prices2::cleanupNull()
     * @doesNotPerformAssertions (remove later)
     */
    public function testCleanupNull()
    {
    }

    /**
     * @covers \Booka\Tours\Prices2::getBooking()
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetBooking()
    {
    }

    /**
     * @covers \Booka\Tours\Prices2::sumBookings()
     * @doesNotPerformAssertions (remove later)
     */
    public function testSumBookings()
    {
    }

    /**
     * @covers \Booka\Tours\Prices2::get()
     * @doesNotPerformAssertions (remove later)
     */
    public function testGet()
    {
    }

    /**
     * @covers \Booka\Tours\Prices2::getDateOffset()
     */
    public function testGetDateOffset()
    {

        $diff = Prices2::getDateOffset('2019-01-01', '2019-02-01');
        self::assertIsInt($diff);
        self::assertEquals($diff, '31');
    }
}
