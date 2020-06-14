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
 * @category   Testing
 * @package    Acceptance
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    NEW
 * @link       https://inkohsamui.com/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Acceptance;

use AcceptanceTester;

/**
 * Test case:
 *
 * - check the API explorer for functionality
 */
class ApiExplorerCest
{

    /**
     * @var array
     */
    static private $restMethods = [
        'accesscontrol' => [
            'accessControlIsAllowed',
        ],
        'customers'     => [
            'customersTabledata',
            'customersSearch',
            'customersBulkedit',
            'customersFollowups',
        ],
        'menus'         => [
            'retrieveMenus',
        ],
        'options'       => [
            'optionsOptions',
        ],
        'ping'          => [
            'createPing',
        ],
        'tours'         => [
            'createAddonSelections',
            'bookingsSeatprice',
            'listCalendar',
            'charterRetrieveTemplate',
            'charterCreateCreate',
            'costsRetrieveNotes',
            'pricesRetrieveBooking',
            'pricesRetrieveSeat',
            'createSeats',
        ],
        'users'         => [
            'usersRole',
        ],
    ];

    /**
     * @param \AcceptanceTester $I
     */
    public function checkForErrorMessage(AcceptanceTester $I)
    {

        $I->amOnPage('/api5/explorer/');
        $I->dontSee('failed to parse JSON/YAML response');

        foreach (static::$restMethods as $key => $values) {
            $headerControl = 'a[data-id=' . $key . ']';
            $I->seeElement($headerControl);
            $I->click($headerControl);
            if (count($values) > 0) {
                foreach ($values as $value) {
                    $I->seeElement('a[href="#!/' . $key . '/' . $value . '"]');
                }
            }
            $I->click($headerControl);
        }
    }
}
