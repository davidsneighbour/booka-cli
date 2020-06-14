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

use Booka\Accounting\TransactionType;
use Codeception\Test\Unit;

/**
 * Class TransactionTypeTest
 *
 * @coversDefaultClass \Booka\Accounting\TransactionType
 */
class TransactionTypeTest extends Unit
{

    /**
     * @covers ::getTypeLabel()
     * @testWith ["PAYMENT", 100, "Payment"]
     *           ["DISCOUNT_CUSTOMER", 200, "Customer Discount"]
     *           ["DISCOUNT_AGENCY", 250, "Agency Discount"]
     *           ["REFUND", 300, "Refund"]
     *           ["PAYOUT", 500, "Payout"]
     *           ["OTHER", 900, "Other"]
     *
     * @param string $slug
     * @param int    $type
     * @param string $label
     */
    public function testGetValue(string $slug, int $type, string $label)
    {
        self::assertSame($type, TransactionType::$slug()->getValue());
        self::assertSame($label, TransactionType::$slug()->getTypeLabel($type));
    }

    /**
     * @covers ::toArray()
     */
    public function testType()
    {
        self::assertIsArray((new TransactionType(100))->toArray());
    }

    /**
     * @covers ::label()
     */
    public function testLabel()
    {
        self::assertSame('TransactionType', TransactionType::label());
    }

}
