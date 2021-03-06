<?php

/**
 * BooKa 13 CLI
 *
 * Copyright (c) 2007-2019 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 7.4
 *
 * @category   Cli
 * @package    Cli
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2019 - David's Neighbour Part., Ltd.
 * @license    https://getbooka.app/license.txt proprietary
 * @version    NEW
 * @link       https://getbooka.app/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Cli\Traits;

/**
 * Trait Testing
 */
trait Testing
{

    /**
     * Testing unit tests and run coverage
     */
    public function test(): void
    {
        $this->testUnit();
        $this->testBrowser();
    }

    public function testUnit(): void
    {
        $this
            ->taskExec('./vendor/bin/codecept run unit --coverage --coverage-xml --coverage-html')
            ->run();
    }

    public function testBrowser(): void
    {
        $this
            ->taskExec('./vendor/bin/codecept run browser --fail-fast')
            ->run();
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function testApi(): void
    {
        $this
            ->taskExec('./vendor/bin/codecept run api --fail-fast')
            ->run();
    }

}
