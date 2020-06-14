<?php /** @noinspection PhpVariableNamingConventionInspection */

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
 * @see        https://codeception.com/docs/06-ReusingTestCode
 * @copyright  All rights reserved. 2007-2018 - David's Neighbour Part., Ltd.
 * @license    license.txt
 * @package    TBD
 * @subpackage TBD
 * @since      11.7.123
 * @version    11.9.65
 * @filesource
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 */

declare(strict_types=1);

namespace Page;

use BrowserTester;

class Login
{
    public static $loginUrl         = '/user/login';

    public static $logoutUrl        = '/user/logout';

    public static $emailField       = 'email';

    public static $passwordField    = 'password';

    public static $formSubmitButton = "submit";

    /**
     * @var BrowserTester
     */
    protected $tester;

    public function __construct(BrowserTester $I)
    {

        $this->tester = $I;
    }

    public function login($email, $password)
    {

        $I = $this->tester;

        // fill and submit form
        $I->amOnPage(self::$loginUrl);
        $I->seeElement('#form-login');
        $I->fillField(self::$emailField, $email);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$formSubmitButton);

        return $this;
    }

    public function logout()
    {

        $I = $this->tester;
        $I->amOnPage(self::$logoutUrl);
        $I->seeElement('.user-loggedout');

        return $this;
    }
}
