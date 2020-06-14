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

use Booka\Core\Transformers\TransformerInt;
use Codeception\Test\Unit;

class TransformerIntTest extends Unit
{

    public function testCreate()
    {
        $this->assertSame(TransformerInt::create(), 0);
        $this->assertSame(TransformerInt::create('1'), 1);
        $this->assertSame(TransformerInt::create('2345435'), 2345435);
    }

}