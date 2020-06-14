<?php /** @noinspection PhpIllegalPsrClassPathInspection */

declare(strict_types=1);

use Codeception\Actor;
use Codeception\Lib\Friend;

/**
 * Inherited Methods
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
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

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
