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

use Booka\Accounting\Accounts;
use Booka\Accounting\AccountTransformer;
use Codeception\Test\Unit;
use DateTime;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;

/**
 * Class AccountsTest
 */
class AccountsTest extends Unit
{

    public function testAccounts()
    {
        $aAccount1 = [
            'userid' => 1,
            'accountingid' => 2100,
            'title' => 'Test Cashbook',
        ];
        $aAccount2 = [
            'userid' => 1,
            'accountingid' => 2100,
            'title' => 'Test Cashbook 2',
        ];
        $newAccount1 = Accounts::post($aAccount1);
        $this->assertTrue(is_array($newAccount1));
        $newAccount2 = Accounts::post($aAccount2);
        $this->assertTrue(is_array($newAccount2));
        $this->assertSame(
            0.0,
            Accounts::getCurrentSaldo($newAccount1['cashid']),
        );
        $this->assertSame(
            0.0,
            Accounts::getSaldo(
                $newAccount1['cashid'],
                new DateTime()
            ),
        );

        $this->assertNotSame($newAccount1, $newAccount2);

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());
        $transformer = new AccountTransformer();

        $resource = new Item($newAccount1, $transformer);
        $data = $manager->createData($resource)->toArray();
        $this->assertTrue(is_array($data));

        $resource = new Item($newAccount2, $transformer);
        $data = $manager->createData($resource)->toArray();
        $this->assertTrue(is_array($data));

        $transactions = Accounts::getTransactions($newAccount1['cashid']);
        $this->assertTrue(is_array($transactions));
        $this->assertTrue(empty($transactions));

        $labels = Accounts::indexLabels();
        $this->assertTrue(is_array($labels));

        $labels2 = Accounts::indexLabels2();
        $this->assertTrue(is_array($labels2));

        $labels3 = Accounts::indexDropdown();
        $this->assertTrue(is_array($labels3));
    }

}
