<?php

/**
 * booka-cli2
 *
 * Copyright (c) 2007-2022 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 8.1
 *
 * @category     Core
 * @package      Cli
 * @author       Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright    2007-2022 - David's Neighbour Part., Ltd.
 * @license      https://getbooka.app/license.txt proprietary
 * @version      2.0.0
 * @link         https://getbooka.app/
 * @since        2.0.0
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

	public function testApi(): void
	{
		$this
			->taskExec('./vendor/bin/codecept run api --fail-fast')
			->run();
	}
}
