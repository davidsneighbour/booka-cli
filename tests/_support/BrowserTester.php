<?php /** @noinspection PhpIllegalPsrClassPathInspection */

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
 * @category   Tests
 * @package    Tests
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2018 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.65
 * @link       https://inkohsamui.com
 * @since      11.7.123
 * @filesource
 *
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = null)
 */

declare(strict_types=1);

use Codeception\Actor;
use Codeception\Lib\Friend;

/**
 * Class BrowserTester
 */
class BrowserTester extends Actor
{

    use _generated\BrowserTesterActions;

    /**
     * @param string $email
     * @param string $password
     */
    public function login($email, $password)
    {

        $I = $this;
        $I->amOnPage('/user/login');
        $I->seeElement('body.user-loggedout');
        $I->fillField(['name' => 'email'], $email);
        $I->fillField(['name' => 'password'], $password);
        $I->click('#form-login button[type=submit]');
        $I->amOnPage('/');
        $I->seeElement('body.user-loggedin');
    }

    /**
     * @param string $email
     * @param string $password
     */
    public function loginFails($email, $password)
    {

        $I = $this;
        $I->amOnPage('/user/login');
        $I->seeElement('body.user-loggedout');
        $I->fillField(['name' => 'email'], $email);
        $I->fillField(['name' => 'password'], $password);
        $I->click('#form-login button[type=submit]');
        $I->amOnPage('/');
        $I->seeElement('body.user-loggedout');
    }

    public function logout()
    {

        $I = $this;
        $I->amOnPage('/user/logout');
        $I->amOnPage('/');
        $I->seeElement('body.user-loggedout');
    }

    /**
     * checks that no obvious errors are visible on a page
     * including
     * - scream error (xdebug's suppressed error indicator)
     */
    public function seeNoObviousError()
    {

        $I = $this;
        $I->dontSee('SCREAM: Error suppression ignored for');
        $I->dontSeeElement('table.xdebug-error');
    }

}
