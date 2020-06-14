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

use Booka\Core\Autotasks\CronjobType;
use Codeception\Test\Unit;

/**
 * Class CronjobTypeTest
 *
 * @coversDefaultClass CronjobType
 */
class CronjobTypeTest extends Unit
{

    /**
     * @covers \Booka\Core\Autotasks\CronjobType::getTypeLabel
     */
    public function testCronjobType()
    {

        $tester = [
            [200, 'INDEFINITE', 'Indefinitely'],
            [300, 'ONCE', 'Once'],
            [400, 'MULTIPLE', 'Multiple'],
            [700, 'SPECIALOWNER', 'Special (Owner)'],
            [800, 'SPECIALADMIN', 'Special (Admin)'],
        ];

        foreach ($tester as $test) {
            // check if key/value exists
            CronjobType::isValidKey($test[1]);
            CronjobType::isValid($test[2]);

            // create enum object via integer
            $object = new CronjobType($test[0]);
            // check if value is integer
            static::assertIsInt($object->getValue());
            // check if correct key name is given
            static::assertEquals($test[1], $object->getKey());
            // check if correct label is returned
            static::assertEquals($test[2], $object::getTypeLabel($object->getValue()));

            // create enum object via constant
            $constant = $test[1];
            $object = CronjobType::$constant();
            // check if value is integer
            static::assertIsInt($object->getValue());
            // check if correct key name is given
            static::assertEquals($test[1], $object->getKey());
            // check if correct label is returned
            static::assertEquals($test[2], $object::getTypeLabel($object->getValue()));
        }

        // check non-existing object
        static::assertEquals(false, CronjobType::isValidKey('NONEXISTING'));
        static::assertEquals('n/a', CronjobType::getTypeLabel(1234));

        // check that the constant count is right
        static::assertEquals(count($tester), count(CronjobType::toArray()) / 2);
    }

}
