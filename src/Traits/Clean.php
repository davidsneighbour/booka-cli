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
 * PHP Version 8.1
 *
 * @category   Cli
 * @package    Cli
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2019 - David's Neighbour Part., Ltd.
 * @license    https://getbooka.app/license.txt proprietary
 * @version    11.18
 * @link       https://getbooka.app/
 * @since      11.18
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Cli\Traits;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListPaths;
use LogicException;

/**
 * Trait Clean
 */
trait Clean
{

	/**
	 * Clean caches and (with --full parameter) packages/libraries
	 *
	 * @param array $opts
	 */
	public function clean(array $opts = ['full|f' => false]): void
	{
		$this->cleanTemps();

		if (isset($opts['full'])) {
			foreach ([
				static::$rootdir . '/public/javascripts/node_modules',
				static::$rootdir . '/vendor',
				static::$rootdir . '/node_modules',
			] as $sDirectory) {
				if (file_exists($sDirectory)) {
					$this->taskCleanDir($sDirectory)->run();
				}
			}
		}
	}

	private function cleanTemps(): void
	{
		$this->cleanCache();
		foreach ([
			static::$rootdir . '/tmp',
			static::$rootdir . '/tests/_output',
			static::$rootdir . '/public/api5/documentation',
		] as $sDirectory) {
			if (file_exists($sDirectory)) {
				$this->taskCleanDir($sDirectory)->run();
			}
		}

		$this->writeGitignore(static::$rootdir . '/tests/_output/.gitignore');
	}

	/**
	 * @return void
	 */
	public function cleanCache(): void
	{
		// setting up file system
		try {
			$adapter = new Local('/');
			$filesystem = new Filesystem($adapter);
			$filesystem->addPlugin(new ListPaths());
		} catch (LogicException $eException) {
			die('path not found');
		}

		$dirs = $filesystem->listPaths(static::$rootdir . '/cache/');

		foreach ($dirs as $dir) {
			$sDir = '/' . $dir;
			if (!is_file($sDir)) {
				foreach ([
					$sDir . '/smarty/templates_c/',
					$sDir . '/smarty/cache/',
				] as $sDirectory) {
					if (file_exists($sDirectory)) {
						$this->taskCleanDir($sDirectory)->run();
					}
				}
			}
		}
		$sApiCache = static::$rootdir . '/public/api5/cache/';
		if (file_exists($sApiCache)) {
			$this->taskCleanDir($sApiCache)->run();
		}

		$this->writeGitignore(static::$rootdir . '/public/api5/cache/.gitignore');
	}

	/**
	 * @param string $filename
	 */
	private function writeGitignore(string $filename): void
	{
		$this->taskWriteToFile($filename)
			->line('*')
			->line('!.gitignore')
			->run();
	}

	/**
	 * cleanup temporary directories and build files
	 *
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function cleanup(): void
	{
		$this->cleanTemps();
	}
}
