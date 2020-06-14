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
 * @category   NEW
 * @package    NEW
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    NEW
 * @link       https://inkohsamui.com/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Accounting;

use Booka\Accounting\Liabilities;
use Codeception\Test\Unit;

class LiabilitiesTest extends Unit
{

    public function testLiabilities()
    {
        // add testcustomer
        // add liability for test customer
        $this->assertFalse(Liabilities::hasLiabilities(1));
        $this->assertFalse(Liabilities::hasLiabilitiesAccount(1));
    }



    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetByCustomer()
    {
    }

    /**
     * @doesNotPerformAssertions (remove later)
     */
    public function testGetBalanceByCustomer()
    {
    }

}
