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
 * Class UsersChangelogCest
 */
class UsersChangelogCest
{

    /**
     * @param \BrowserTester $I
     */
    public function changelogTest(\BrowserTester $I)
    {

        $I->wantToTest('the display of the changelog in HTML format');
        $I->amOnPage('/user/changelog/');
        $I->see('Changelog');
        $I->dontSeeElement('.error-screen');
    }
}
