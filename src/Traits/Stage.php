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

/**
 * Trait Stage
 *
 * Deployment of BooKa on configured stages
 */
trait Stage
{

    /**
     * Update stages to most current versions
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function stage(): void
    {
        // ask for stage
        $stage = $this->requestLocations();

        // retrieve setup
        $remote = static::$setup['stages'][$stage['name']][$stage['type']];
        $message = 'Staging starting for ' . $stage['name'] . '[' . $stage['type'] . ']';
        $this->notifySlack($message, $remote['slack']);
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
        $remoteHandler->exec('touch .maintenance')
            ->exec('rm -f favicon.*')
            ->exec('git checkout -- .')
            ->exec('git checkout master')
            ->exec('git pull && git fetch')
            ->exec('git checkout `git tag | sort -r --version-sort | head -n1`')
            ->exec('git submodule update')
            ->exec('npm run build-changelog');

        if ($stage['type'] === 'live') {
            $message = 'Committing remote file directory';
            $this->notifySlack($message, $remote['slack']);
            $remoteHandler->exec('cd public/files/' . $remote['slug'])
                ->exec('git add -A')
                ->exec('git diff-index --quiet HEAD || git commit -m "file updates of ' . date('Y-m-d') . '"')
                ->exec('git push origin')
                ->exec('cd ../../..');
        }

        $remoteHandler
            ->exec('rm -rf public/api5/cache/*')
            ->exec('/usr/local/php74/bin/php ~/.php/composer/composer install')
            ->exec('npm install')
            ->exec('yarn install')
            ->exec('echo "' . $remote['servername'] . '" > .server')
            ->exec('npm run build')
            ->exec('npm run css2')
            ->exec('npm run postcss2')
            ->exec('rm .maintenance');

        $remoteHandler
            ->run();

        $this->sentryDeployNotification($remote);
        $message = 'Staging done for ' . $stage['name'] . '[' . $stage['type'] . ']';
        $this->notifySlack($message, $remote['slack']);
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
        if ((bool)$confirmation === true) {
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
        $installations = array_combine(range(1, count($installations)), array_values($installations));
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
        $types = array_combine(range(1, count($types)), array_values($types));

        $type = $this->io()->choice(
            'Which installation type?',
            $types
        );

        return $type;
    }

}
