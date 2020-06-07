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
        $installations = array_keys(static::$setup['stages']);
        try {
            $installations = array_combine(
                range(1, count($installations)),
                array_values($installations)
            );
            $installations[0] = 'all';
        } catch (ArrayException $eException) {
            exit('Unable to load stages.'); // NOSONAR
        }
        $install = $this->io()->choice(
            'Select database to download',
            $installations,
            $installations[0]
        );

        if ($install === 'all') {
            /**
             * @psalm-suppress PossiblyNullIterator
             */
            foreach (static::$setup['stages'] as $key => $item) {
                if (isset($item['live'])) {
                    $this->io()->comment('Retrieving ' . $key);

                    // retrieve setup
                    $remote = $item['live'];
                    $local = static::$setup['local'][$remote['local']];
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
            $this->executeDBBackup($remote, $local);
        }
    }

    private function executeDBBackup(array $remote, array $local): void
    {
        $remotedbpath = $remote['sshpath'] . '/db.sql';
        $localdbpath = static::$rootdir . '/db.sql';

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
            ->toPath($localdbpath)
            ->fromHost($remote['sshhost'])
            ->fromUser($remote['sshuser'])
            ->fromPath($remotedbpath)
            ->compress()
            ->run();

        // load into local database
        $command = $this->createMysqlCommand($local) . ' < ';
        $command .= $localdbpath;
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
        $this->taskExec('rm ' . $localdbpath)
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

}
