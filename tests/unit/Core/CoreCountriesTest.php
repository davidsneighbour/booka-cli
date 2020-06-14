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

namespace Booka\Testing\Unit\Core;

use Booka\Core\Countries;
use Codeception\Test\Unit;

/**
 * Class CoreCountriesTest
 *
 * @coversDefaultClass Booka\Core\Countries
 */
class CoreCountriesTest extends Unit
{

    /**
     * @covers \Booka\Core\Countries::index()
     * @covers \Booka\Core\Countries::get()
     */
    public function testIndex()
    {

        $aCountries = Countries::index();

        foreach (['de' => 'Germany', 'th' => 'Thailand'] as $key => $value) {
            static::assertArrayHasKey($key, $aCountries);
            static::assertSame($value, $aCountries[$key]);
        }
        self::assertArrayHasKey('gb', $aCountries);
        self::assertGreaterThanOrEqual(245, Countries::index());

        $aCountries = Countries::index(true);
        $sFirst = array_shift($aCountries);
        self::assertEquals('Select ...', $sFirst);

        $testCountry = Countries::get('de');
        self::assertArrayHasKey('name', $testCountry);
        self::assertEquals('DE', $testCountry['alpha2']);
        self::assertEquals('DEU', $testCountry['alpha3']);
        self::assertEquals('Germany', $testCountry['name']);
        self::assertEquals('EUR', $testCountry['currency'][0]);
    }

}
