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
 * Class UserrolesCest
 */
class UserrolesCest
{

    /**
     * @param \BrowserTester $I
     */
    public function ownerTest(\BrowserTester $I)
    {

        $I->wantToTest('if owner sees all features he has rights to see.');
        $I->login('testowner@example.com', 'testowner');
    }
}
