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

namespace Booka\Testing\Browser;

/**
 * Class UsersCest
 */
class UsersCest
{

    /**
     * Test if a session is properly ended on logout
     *
     * @param \BrowserTester $I $I testing object
     *
     * @return void
     */
    public function clearoutUserTest(\BrowserTester $I)
    {

        $I->wantToTest('if a session is properly ended on logout');
        $I->login('testowner@example.com', 'testowner');
        $I->logout();
        $I->dontSeeCookie('PHPSESSID');
    }

    /**
     * Test if account testdeactivated is properly locked out
     *
     * @param \BrowserTester $I testing object
     *
     * @return void
     */
    public function checkUserDeactivated(\BrowserTester $I)
    {

        $I->wantToTest('if `testdeactivated` is locked out effectively');
        $I->loginFails('testdeactivated@example.com', 'testdeactivated');
    }

    /**
     * Testing:
     *
     * - go to https://booka/users/
     * - look for testdeactivated
     * $I->click('Edit' , \Codeception\Util\Locator::elementAt('//table/tr', -1));
     * Locator::contains('div[@contenteditable=true]', 'hello world');
     * - click activate
     * - check if it's activated
     * - click deactivate
     * - check if it's deactivated
     *
     * - click add button
     * - create test user with unique id
     * - save form
     * - check if user is active
     *
     * - logout
     * - login as test user
     * - check if user sees *
     * - change password
     * - change name
     * - logout
     *
     * - login with new password
     * - logout
     *
     * - login as owner
     * - change password for testuser
     * - logout
     *
     * - login as testuser
     * - logout
     *
     * - login as owner
     * - delete testuser
     * - logout
     */
}
