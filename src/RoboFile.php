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

namespace Booka\Cli;

use Booka\Cli\Traits\{Build,
    Clean,
    Database,
    Development,
    Documentation,
    Env,
    QualityInsurance,
    Release,
    Setup,
    Stage,
    Testing,
    Wordpress
};
use Curl\Curl;
use Grasmash\YamlExpander\Expander;
use Robo\{ResultData, Tasks};
use Robo\Contract\VerbosityThresholdInterface;
use RuntimeException;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\JsonException;

use function Safe\file_get_contents;
use function Safe\json_encode;

/**
 * Class RoboFile
 *
 * RoboFile stub to be used with all task classes. Loads setup and adds re-used methods.
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class RoboFile extends Tasks
{

    use Build;
    use Clean;
    use Database;
    use Development;
    use Documentation;
    use Env;
    use QualityInsurance;
    use Release;
    use Setup;
    use Stage;
    use Testing;
    use Wordpress;

    /**
     * @var string $rootdir directory in which the robo command is run
     */
    protected static $rootdir;

    /**
     * @var null|array
     */
    protected static $setup;

    /**
     * @var string API directory of Booka
     */
    protected static $apidir = 'src/Booka';

    /**
     * RoboFile constructor.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __construct()
    {
        // grabbing configuration from booka.yml file in the config directory
        if (!is_array(static::$setup)) {
            try {
                $setup = file_get_contents(static::$rootdir . '/config/booka.yml');
                static::$setup = Expander::parse($setup);
            } catch (FilesystemException $eException){}
        }
    }

    public function taskNotifySentry(): void
    {
        $this->stopOnFail(true);

        // check if sentry is installed
        $this->checkSentry();

        // current booka version
        $sVersion = 'VERSION=`cat .version` && ';

        // environmental variables for sentry
        // set up via config/booka.yml
        $sEnvironventVars = 'export SENTRY_ORG=' . static::$setup['sentry']['org'] . ' && ';
        $sEnvironventVars .= 'export SENTRY_PROJECT=' . static::$setup['sentry']['project'] . ' && ';
        $sEnvironventVars .= 'export SENTRY_DSN=' . static::$setup['sentry']['dsn'] . ' && ';
        $sEnvironventVars .= 'export SENTRY_AUTH_TOKEN=' . static::$setup['sentry']['token'] . ' && ';

        // send release info
        $sReleaseInfo = './node_modules/.bin/sentry-cli releases new "$VERSION" && ';
        $sReleaseInfo .= './node_modules/.bin/sentry-cli releases finalize "$VERSION" && ';

        // send commit info
        $sCommitInfo = './node_modules/.bin/sentry-cli releases set-commits --auto $VERSION';

        $this->io()->note('Update sentry.io');
        $this->taskExecStack()
            ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->exec(
                $sVersion .
                $sEnvironventVars .
                $sReleaseInfo .
                $sCommitInfo
            )
            ->run();
        $this->io()->note('Update sentry.io - done');

        return;
    }

    /**
     * @return ResultData|null
     */
    protected function checkSentry()
    {
        $filename = static::$rootdir . '/node_modules/.bin/sentry-cli';

        if (!file_exists($filename)) {
            $this->io()->error('sentry-cli is not installed. Run `npm install`.');

            return new ResultData(-1);
        }
    }

    /**
     * Notify sentry.io of release deploy to a certain deployment stage
     *
     * @param array $remote
     *
     */
    protected function sentryDeployNotification(array $remote): void
    {
        // @todo check if sentry-cli is set up properly and warn if not
        // @todo add duration of staging

        //        start=$(date +%s)
        //...
        //now=$(date +%s)
        //sentry-cli releases deploys VERSION new -e ENVIRONMENT -t $((now-start))

        // script to retrieve the latest tagged version per semver rules
        $sSentryCommand = sprintf(
            './node_modules/.bin/sentry-cli releases deploys %s new -e %s',
            exec('git tag | sort -r --version-sort | head -n1'),
            $remote['servername']
        );

        // notify sentry.io of new deploy
        $this->taskExecStack()
            ->stopOnFail()->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->exec($sSentryCommand)->run();
    }

    /**
     * @param array  $payload
     * @param string $message
     * @param array  $slack = [
     *                      'channel' => 'channelcode',
     *                      'hook'    => 'hook',
     *                      ]
     *
     */
    protected function notifySlack(string $message, array $slack, array $payload = []): void
    {
        try {
            $aPayload = json_encode(
                [
                    'username' => $payload['username'] ?? 'BooKa',
                    'icon_emoji' => $payload['icon_emoji'] ?? ':male-construction-worker:',
                    'channel' => $slack['channel'],
                    'text' => $message,
                ]
            );
        } catch (JsonException $eException) {
            $aPayload = '';
        }

        $aPayloadPrepared = [
            "payload" => $aPayload,
        ];

        try {
            $curl = new Curl();
            $curl->post($slack['hook'], $aPayloadPrepared);
        } catch (RuntimeException $eException) {
        }
    }

    /**
     * @param array  $extra
     * @param string $message
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    protected function sentrySendEvent(string $message, array $extra = []): void
    {
        $sEnvironventVars = 'export SENTRY_DSN=' . static::$setup['sentry']['dsn'] . ' && ';
        $sMessage = './node_modules/.bin/sentry-cli send-event -m "' . $message . '"';

        $sExtra = '';
        if (count($extra) > 0) {
            foreach ($extra as $key => $value) {
                $sExtra .= ' -e ' . strval($key) . ':' . $value . ' ';
            }
        }

        $sRelease = ' --release ';

        $this->taskExecStack()
            ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->exec(
                $sEnvironventVars .
                $sMessage .
                $sExtra .
                $sRelease
            )
            ->run();

        return;
    }

}
