<?php

/**
 * BooKa 12
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
 * @category   Cli
 * @package    Cli
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2022 - David's Neighbour Part., Ltd.
 * @license    https://getbooka.app/license.txt proprietary
 * @version    11.18
 * @link       https://getbooka.app/
 * @since      11.18
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Cli\Traits;

use Booka\Core\Configuration\Config;
use Symfony\Component\Yaml\Yaml;

trait Maintenance
{

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function maintenance(): void
	{
		$action = '';
		$stage = Yaml::parseFile(static::$rootdir . '/config/staging.' . Config::getServername() . '.yml');

		while ($action !== 'x') {
			$this->io()->title('BooKa Maintenance');
			$this->say('Current Version: ' . Config::getVersion());
			$this->say('Current Server: ' . Config::getServername());
			$this->io()->newLine();
			$this->io()->newLine();
			$action = $this->io()->choice(
				'What do you want to do?',
				[
					'1' => 'Upgrade to latest version',
					'x' => 'Quit',
				],
				'x'
			);

			switch ($action) {
				case '1':
					$this->maintenanceUpgrade($stage);
					break;
			}

			$this->io()->newLine();
			$this->io()->newLine();
		}

		$this->io->text('Good Bye!');
	}

	/**
	 * @param array<array-key, string> $stage
	 */
	private function maintenanceUpgrade($stage = []): void
	{
		if (count($stage) === 0) {
			$this->say('stage setup not found');
			return;
		}

		$message = 'Staging starting for ' . $stage['slug'] . '[' . $stage['type'] . ']';
		$this->notifySlack($message, $stage['slack']);

		$this->io()->section('Upgrade to latest tag version');
		$this->say('cleanup');
		$this->_exec('touch .maintenance');
		$this->_exec('nvm use v14.10.0');
		$this->_exec('rm -f favicon.*');
		$this->_exec('rm -f composer.lock');
		$this->_exec('rm -f package-lock.json');

		$this->_exec('git stash');
		$this->_exec('git checkout -- .');
		$this->_exec('git checkout main');
		$this->_exec('git pull && git fetch');
		$this->_exec('git checkout `git tag | sort -r --version-sort | head -n1`');
		$this->_exec('git submodule update');

		if ($stage['type'] === 'live') {
			$message = 'Committing remote file directory';
			$this->notifySlack($message, $stage['slack']);
			$this->say($message);
			$this->_exec('cd public/files/' . $stage['slug']);
			$this->_exec('git add -A');
			$this->_exec('git diff-index --quiet HEAD || git commit -m "chore: file updates of ' . date('Y-m-d') . '"');
			$this->_exec('git push origin');
			$this->_exec('cd ../../..');
		}

		$this->_exec('rm -rf public/api5/cache/*');
		$this->_exec('php -d memory_limit=-1 ~/.php/composer/composer install');
		$this->_exec('php -d memory_limit=-1 ~/.php/composer/composer check-platform-reqs');
		$this->_exec('npm install');
		//$this->_exec('yarn install');
		$this->_exec('echo "' . $stage['servername'] . '" > .dotfiles/.server');
		$this->_exec('npm run build');
		$this->_exec('npm run css2');
		$this->_exec('npm run postcss2');
		$this->_exec('./vendor/bin/phinx migrate');
		$this->_exec('rm .maintenance');

		//$this->sentryDeployNotification($stage);
		$message = 'Staging done for ' . $stage['name'] . '[' . $stage['type'] . ']';
		$this->notifySlack($message, $stage['slack']);
	}
}
