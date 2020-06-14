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

namespace Booka\Testing\Unit\Core\Helpers;

use Booka\Core\Helpers\Initials;
use Codeception\Test\Unit;

class InitialsTest extends Unit
{

    public function testGenerate()
    {

        $this->assertSame('CH', Initials::generate('Charly'));
        $this->assertSame('CB', Initials::generate('Charly Brown'));
        $this->assertSame('CB', Initials::generate('Charly Dexter Brown'));
        $this->assertSame('JM', Initials::generate('John McDonalds'));

    }

}
