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
 * @category   Testing
 * @package    Core
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    NEW
 * @link       https://inkohsamui.com/
 * @since      NEW
 * @filesource
 * @subpackage Transformers
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Core\Transformers;

use Booka\Core\Transformers\TransformerBool;
use Codeception\Test\Unit;

class TransformerBoolTest extends Unit
{

    public function testCreate()
    {
        $aTrueValues = [true, 'true', 'True', 'yes', 'Yes', 'on', 'On', '1', 1,];

        foreach ($aTrueValues as $value) {
            static::assertTrue(TransformerBool::create($value));
        }

        $aFalseValues = [null, false, 'false', 'no', 'off', '0', 0, 'something'];

        foreach ($aFalseValues as $value) {
            static::assertFalse(TransformerBool::create($value));
        }
    }

}
