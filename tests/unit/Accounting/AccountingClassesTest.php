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

use Booka\Accounting\AccountingClasses;
use Codeception\Test\Unit;

/**
 * Class AccountingClassesTest
 *
 * @coversDefaultClass \Booka\Accounting\AccountingClasses
 */
class AccountingClassesTest extends Unit
{

    /**
     * @covers ::indexLabels()
     */
    public function testIndexLabels()
    {
        $aIndex = AccountingClasses::indexLabels(false);
        $aIndex2 = AccountingClasses::indexLabels(true);
        self::assertTrue(is_array($aIndex));
        self::assertTrue(is_array($aIndex2));
        self::assertTrue(count($aIndex) === count($aIndex2) - 1);
    }

    /**
     * @covers ::get()
     * @testWith [2100,"Cash"]
     *           [2200,"Bank"]
     *           [2300,"Accounts Receivable"]
     *           [2310,"Customer Liabilities"]
     *           [2350,"Accounts Receivable (Agents)"]
     *           [2400,"Prepaid Expenses"]
     *           [2500,"Inventory (Stock on Hand)"]
     *           [2600,"Other Assets"]
     *           [4100,"Accounts Payable (Vendors)"]
     *           [4200,"Credit Cards"]
     *           [4300,"Tax Payable"]
     *           [5100,"Sales Revenue"]
     *           [5200,"Interest Income"]
     *           [5800,"Other Income"]
     *           [6100,"Purchases"]
     *           [6120,"Office Expenses"]
     *           [6180,"Transportation Costs"]
     *           [6200,"Salary and Staff expenses"]
     *           [7100,"Marketing"]
     *           [7200,"Customer discounts"]
     *           [7300,"Agency discounts"]
     *           [7999,"Other Expenses"]
     *           [9999,"Depreciation"]
     *
     * @param int    $classId
     * @param string $classTitle
     */
    public function testGet(int $classId, string $classTitle)
    {
        $aClass = AccountingClasses::get($classId);
        self::assertTrue(is_array($aClass));
        self::assertArrayHasKey('accountid', $aClass);
        self::assertArrayHasKey('class', $aClass);
        self::assertArrayHasKey('title', $aClass);
        self::assertSame(
            $classTitle,
            $aClass['title']
        );
        self::assertTrue(is_int($aClass['accountid']));
        self::assertTrue(is_int($aClass['class']));
        self::assertTrue(is_string($aClass['title']));

        $aClass = AccountingClasses::get(1234);
        self::assertFalse($aClass);
        $aClass = AccountingClasses::get(0);
        self::assertFalse($aClass);
    }

    /**
     * @covers ::getLabel()
     */
    public function testGetLabel()
    {
        $sLabel = AccountingClasses::getLabel(2300);
        self::assertSame('Accounts Receivable', $sLabel);

        $aClass = AccountingClasses::getLabel(1234);
        self::assertFalse($aClass);
    }

    /**
     * @covers ::index()
     * @covers ::splice()
     *
     * @testWith [""]
     *           ["all"]
     *           ["liquid", 2]
     *           ["costs", 8]
     *
     * @param      $slug
     * @param bool $count
     */
    public function testIndex($slug, $count = false)
    {
        $aIndex = AccountingClasses::index($slug);
        self::assertIsArray($aIndex);
        if ($count !== false) {
            self::assertTrue(count($aIndex) === $count);
        }
    }

    /**
     * @covers ::indexByClass()
     * @covers ::spliceByClass()
     *
     * @testWith [2, 8]
     *           [4, 3]
     *           [5, 3]
     *           [6, 4]
     *           [7, 4]
     *           [9, 1]
     *
     * @param int $class
     * @param int $count
     */
    public function testIndexByClass(int $class, int $count = 0)
    {
        $aIndex = AccountingClasses::indexByClass($class);
        self::assertIsArray($aIndex);
        if ($count !== false) {
            self::assertSame($count, count($aIndex));
        }
    }
}
