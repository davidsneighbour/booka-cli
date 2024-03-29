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

use Robo\Contract\VerbosityThresholdInterface;

/**
 * Trait Stage
 *
 * Deployment of BooKa on configured stages
 */
trait Stage
{

	/**
	 * Update stages to most current versions
	 */
	public function stage(): void
	{
		// ask for stage
		$stage = $this->requestLocations();

		/**
		 * @param array<array-key, mixed> $remote remote setup configuration
		 */
		$remote = static::$setup['stages'][$stage['name']][$stage['type']];
		$message = 'Staging starting for ' . $stage['name'] . '[' . $stage['type'] . ']';
		$this->say($message);
		$this->io()->title('Staging now');
		// run remote update
		$remoteHandler = $this->taskSshExec(
			$remote['sshhost'],
			$remote['sshuser']
		)
			->remoteDir($remote['sshpath'])
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG);
		// remote system has a special port for ssh connections
		if (isset($remote['sshport'])) {
			$remoteHandler->port($remote['sshport']);
		}
		$remoteHandler
			->exec('touch .maintenance')
			->exec('nvm use 14.10.0')
			->exec('rm -f favicon.*')
			->exec('rm -f composer.lock')
			->exec('rm -f package-lock.json')
			->exec('git checkout -- .')
			->exec('git checkout main')
			->exec('git pull && git fetch')
			->exec('git checkout `git tag | sort -r --version-sort | head -n1`')
			->exec('git submodule update');
		if ($stage['type'] === 'live') {
			$message = 'Committing remote file directory';
			$this->say($message);
			$remoteHandler->exec('cd public/files/' . $remote['slug'])
				->exec('git add -A')
				->exec('git diff-index --quiet HEAD || git commit -m "file updates of ' . date('Y-m-d') . '"')
				->exec('git push origin')
				->exec('cd ../../..');
		}

		$remoteHandler
			->exec('rm -rf public/api5/cache/*')
			->exec('/usr/local/php74/bin/php -d memory_limit=-1 ~/.php/composer/composer install --no-dev')
			->exec('/usr/local/php74/bin/php -d memory_limit=-1 ~/.php/composer/composer check-platform-reqs --no-dev')
			->exec('npm install')
			->exec('npm rebuild node-sass')
			//->exec('yarn install')
			->exec('echo "' . $remote['servername'] . '" > .dotfiles/.server')
			->exec('npm run build')
			->exec('npm run css2')
			->exec('npm run postcss2')
			//->exec('./vendor/bin/phinx migrate')
			->exec('rm .maintenance');

		$remoteHandler
			->run();

		$message = 'Staging done for ' . $stage['name'] . '[' . $stage['type'] . ']';
		$this->say($message);
	}

	/**
	 * @return mixed[]
	 */
	private function requestLocations(): array
	{
		$this->stopOnFail(true);
		// title
		$this->io()->title('Update Stage - Setup Location');
		// ask which installation
		$name = $this->askRemoteInstallation();
		$live = $this->askRemoteInstallType($name);
		// summarize planned activity
		$this->io()->title('Summary');
		$this->io()->note(
			'We stage to ' . $live . ' stage of ' . $name . '.'
		);
		$confirmation = $this->confirm('Confirm setup');
		if ((bool)$confirmation) {
			return [
				'type' => $live,
				'name' => $name,
			];
		}

		return [];
	}

	/**
	 * @return string
	 */
	private function askRemoteInstallation(): string
	{

		$installations = array_keys(static::$setup['stages']);
		$installations = array_combine(range(1, count($installations)), $installations);
		$name = $this->io()->choice(
			'Which installation?',
			$installations,
			'hdtours'
		);

		return $name;
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	private function askRemoteInstallType(string $name): string
	{

		$types = array_keys(static::$setup['stages'][$name]);
		$types = array_combine(range(1, count($types)), $types);

		$type = $this->io()->choice(
			'Which installation type?',
			$types
		);

		return $type;
	}

	public function migrateDatabase() :void
	{
		// ask for stage
		$stage = $this->requestLocations();
		$this->io()->note(
			'Starting database migration.'
		);
		/**
		 * @param array<array-key, string> $remote
		 */
		$remote = static::$setup['stages'][$stage['name']][$stage['type']];
		$remoteHandler = $this->taskSshExec(
			$remote['sshhost'],
			$remote['sshuser']
		)
			->remoteDir($remote['sshpath'])
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG);

		$command = 'export PHINX_DB_HOST="' . $remote['dbhost'] . '"';
		$command .= 'export PHINX_DB_NAME="' . $remote['dbname'] . '"';
		$command .= 'export PHINX_DB_USER="' . $remote['dbuser'] . '"';
		$command .= 'export PHINX_DB_PASS="' . $remote['dbpass'] . '"';
		$command .= './vendor/bin/phinx migrate';

		$remoteHandler->exec($command);
	}
}
