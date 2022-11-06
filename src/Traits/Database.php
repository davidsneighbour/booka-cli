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

use Robo\Contract\VerbosityThresholdInterface;
use Safe\Exceptions\ArrayException;

use function Safe\array_combine;

/**
 * Trait Database
 */
trait Database
{

	/**
	 * Synchronize remote databases to local installation
	 *
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function database(): void
	{
		// ask for remote installation
		$install = $this->getStageLocation('download', true);

		if ($install === 'all') {
			/**
			 * @psalm-suppress PossiblyNullIterator
			 */
			foreach (static::$setup['stages'] as $key => $item) {
				if (isset($item['live'])) {
					/** @noinspection PhpDeprecationInspection */
					$this->io()->comment('Retrieving ' . $key);

					// retrieve setup
					$remote = $item['live'];
					$local = static::$setup['local'][$remote['local']];
					$this::emptyDatabase($local);
					$this->executeDBBackup($remote, $local);
				}
			}
		} else {
			// retrieve setup
			$remote = static::$setup['stages'][$install]['live'];
			/**
			 * @psalm-suppress PossiblyNullArrayOffset
			 */
			$local = static::$setup['local'][$remote['local']];
			$this::emptyDatabase($local);
			/**
			 * @psalm-suppress PossiblyNullArgument
			 */
			$this->executeDBBackup($remote, $local);
		}
	}

	private function getStageLocation($term = 'download', $all = true)
	{
		// ask for remote installation
		/**
		 * @psalm-suppress PossiblyNullArgument
		 * @psalm-suppress PossiblyNullArrayAccess
		 */
		$installations = array_keys(static::$setup['stages']);
		try {
			$installations = array_combine(
				range(1, count($installations)),
				array_values($installations)
			);
			if ($all === true) {
				$installations[0] = 'all';
			}
		} catch (ArrayException $eException) {
			exit('Unable to load stages.'); // NOSONAR
		}
		/** @noinspection PhpUnnecessaryLocalVariableInspection */
		/** @noinspection PhpDeprecationInspection */
		$install = $this->io()->choice(
			'Select database to ' . $term,
			$installations,
			($all === true) ? $installations[0] : $installations[1]
		);
		return $install;
	}

	private function emptyDatabase(array $config): void
	{
		$this->io()->note('Emptying local database...');
		$mysql = "mysql -h " . $config['dbhost'] . " -u " . $config['dbuser'] . " ";
		$mysql .= "-p" . $config['dbpass'] . " " . $config['dbname'] . "";
		$command = $mysql . " -BNe \"show tables\" | ";
		$command .= "awk '{print \"set foreign_key_checks=0; drop table `\" $1 \"`;\"}' | " . $mysql;

		$this->taskExecStack()
			->stopOnFail()
			->exec($command)
			->exec($command)
			->exec($command)
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->run();
	}

	private function executeDBBackup(array $remote, array $local): void
	{
		$remoteDbPath = $remote['sshpath'] . '/db.sql';
		$localDbPath = static::$rootdir . '/db.sql';

		// go remote and dump database
		$command = $this->createMysqlCommand($remote, true) . ' > db.sql';
		$this->taskSshExec($remote['sshhost'], $remote['sshuser'])
			->remoteDir($remote['sshpath'])
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->exec($command)
			->run();

		// load remote database to local temp
		$this->taskRsync()
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->toPath($localDbPath)
			->fromHost($remote['sshhost'])
			->fromUser($remote['sshuser'])
			->fromPath($remoteDbPath)
			->compress()
			->run();

		// load into local database
		$command = $this->createMysqlCommand($local) . ' < ';
		$command .= $localDbPath;
		$this->taskExec($command)
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->run();

		// remove remote file
		$this->taskSshExec($remote['sshhost'], $remote['sshuser'])
			->remoteDir($remote['sshpath'])
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->exec('rm db.sql')
			->run();

		// remove local file
		$this->taskExec('rm ' . $localDbPath)
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->run();

		// import testing data
		$command = $this->createMysqlCommand($local) . ' < ';
		$command .= static::$rootdir . '/tests/_data/testing-changes.sql ';
		$this->taskExec($command)
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->run();
	}

	/**
	 * create command to connect a user to a database
	 *
	 * @param array $server database setup
	 * @param bool  $dump   if the connection is used for a database dump
	 *
	 * @return string
	 */
	private function createMysqlCommand($server, $dump = false): string
	{
		$command = ($dump) ? 'mysqldump' : 'mysql';
		$command .= ' -h ' . $server['dbhost'];
		$command .= ' -u ' . $server['dbuser'];
		$command .= ' -p' . $server['dbpass'];
		$command .= ' ' . $server['dbname'];
		return $command;
	}

	/**
	 * copy databases between live and dev stages
	 *
	 * @noinspection PhpUnused
	 */
	public function databaseCopy(): void
	{
		$install = $this->getStageLocation('copy', false);

		// retrieve setup
		/**
		 * @psalm-suppress PossiblyNullArrayAccess
		 */
		$remote1 = static::$setup['stages'][$install]['live'];
		/**
		 * @psalm-suppress PossiblyNullArgument
		 */
		$command1 = $this->createMysqlCommand($remote1, true) . ' > db.sql';
		/**
		 * @psalm-suppress PossiblyNullArrayAccess
		 */
		$remote2 = static::$setup['stages'][$install]['dev'];
		/**
		 * @psalm-suppress PossiblyNullArgument
		 */
		$command2 = $this->createMysqlCommand($remote2, false) . ' < db.sql';

		// go remote and dump database
		$this->executeCommand(
			$remote2,
			$command1,
			'Dumping database ' . $remote1['dbname']
		);
		$this->executeCommand(
			$remote2,
			$command2,
			'Loading dumped database into ' . $remote2['dbname']
		);
		$this->executeCommand(
			$remote2,
			'rm db.sql',
			'Cleanup db.sql'
		);
	}

	/**
	 * executes a command remotely
	 *
	 * @param array  $remote
	 * @param string $command
	 * @param string $note
	 */
	private function executeCommand(array $remote, string $command, string $note)
	{
		/** @noinspection PhpDeprecationInspection */
		$this->io()->note($note);
		$this->taskSshExec($remote['sshhost'], $remote['sshuser'])
			->remoteDir($remote['sshpath'])
			->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
			->exec($command)
			->run();
	}
}
