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

use Booka\Core\Autotasks\CronjobStatus;
use Codeception\Test\Unit;

/**
 * Class CronjobStatusTest
 *
 * @coversDefaultClass CronjobStatus
 */
class CronjobStatusTest extends Unit
{

    /**
     * @covers \Booka\Core\Autotasks\CronjobStatus::getStatusLabel
     */
    public function testCronjobStatus()
    {

        $tester = [
            [100, 'NEW', 'New'],
            [200, 'OK', 'OK'],
            [600, 'ERROR', 'Error'],
            [999, 'DELETED', 'Deleted'],
        ];

        foreach ($tester as $test) {
            // check if key/value exists
            CronjobStatus::isValidKey($test[1]);
            CronjobStatus::isValid($test[2]);

            // create enum object via integer
            $object = new CronjobStatus($test[0]);
            // check if value is integer
            static::assertIsInt($object->getValue());
            // check if correct key name is given
            static::assertEquals($test[1], $object->getKey());
            // check if correct label is returned
            static::assertEquals($test[2], $object::getStatusLabel($object->getValue()));

            // create enum object via constant
            $constant = $test[1];
            $object = CronjobStatus::$constant();
            // check if value is integer
            static::assertIsInt($object->getValue());
            // check if correct key name is given
            static::assertEquals($test[1], $object->getKey());
            // check if correct label is returned
            static::assertEquals($test[2], $object::getStatusLabel($object->getValue()));
        }

        // check non-existing object
        static::assertEquals(false, CronjobStatus::isValidKey('NONEXISTING'));
        static::assertEquals('n/a', CronjobStatus::getStatusLabel(1234));

        // check that the constant count is right
        static::assertEquals(count($tester), count(CronjobStatus::toArray()) / 2);
    }

}
