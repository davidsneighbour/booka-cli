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
 * Trait Wordpress
 */
trait Wordpress
{

	/**
	 *
	 */
	public function wpCompile(): void
	{
		$wpPluginFile = 'public/dnb_booka_calendar.zip';
		$this->_exec('rm ' . $wpPluginFile);

		$aVersion = $this->getVersionArray();
		$sVersion = $this->getVersion($aVersion);

		foreach ([
			'wp/booka-calendar.js',
			'wp/dnb-booka-calendar.css',
			'wp/dnb-booka-calendar.php',
		] as $file) {
			$this->taskReplaceInFile(static::$rootdir . '/' . $file)
				->regex('( \* Version:[\ ]*([0-9\.])*)')
				->limit(1)
				->to(' * Version:     ' . $sVersion)
				->run();
		}

		$this->taskPack($wpPluginFile)
			->addDir('dnb_booka_calendar', 'wp')
			->run();
	}
}
